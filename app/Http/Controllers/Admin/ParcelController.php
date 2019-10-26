<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ParcelService;
use App\Services\GuestService;
use App\Request\Admin\CreateParcel;
use App\Models\Parcel;
use App\Request\Admin\CompleteTransfer;
use App\Exports\ParcelExport;
use Excel;

class ParcelController extends Controller
{
    private $parcelService;
    private $guestService;
    private $varsIndexKeys = [
        'keyword',
        'guest_id',
        'status',
        'dates',
    ];

    public function __construct(ParcelService $parcelService, GuestService $guestService)
    {
        $this->parcelService = $parcelService;
        $this->guestService = $guestService;
    }

    public function index(Request $request)
    {
        $search = self::getSearchParams($request);
        $data = [
            'user'     => $request->user(),
            'guests'   => $this->parcelService->guestList(),
            'search'   => $search,
            'parcels'  => $this->parcelService->getList($search),
            'statuses' => $this->parcelService->getStatuses(),
        ];
        return view('admin.parcel.index', $data);
    }

    private function getSearchParams(Request $request)
    {
        $keyword  = $request->has('keyword')  ? $request->keyword  : '';
        $guest_id = $request->has('guest_id') ? $request->guest_id : null;
        $dates    = $request->has('dates')    ? $request->dates    : getNowDatepicker();
        $status   = $request->has('status')   ? $request->status   : null;
        if ($request->session()->has('_old_input')) {
            $input    = $request->session()->get('_old_input');
            $keyword  = data_get($input, 'keyword');
            $guest_id = data_get($input, 'guest_id');
            $dates    = data_get($input, 'dates');
            $status   = data_get($input, 'status');
        }
        $rs = [
            'keyword'  => $keyword,
            'guest_id' => $guest_id,
            'dates'    => $dates,
            'status'   => $status,
        ];
        return $rs;
    }

    public function export(Request $request)
    {
        // set error level
        $internalErrors = libxml_use_internal_errors(true);
        $params['search'] = self::getSearchParams($request);
        $parcels = $this->parcelService->getList($params['search'], true);
        $params['amounts'] = self::calTotalAmount($parcels);
        list($fileName, $params['guest']) = self::parcelFileName($params['search']);
        $excel = Excel::download(new ParcelExport($parcels, $params), $fileName);
        // Restore error level
        libxml_use_internal_errors($internalErrors);
        return $excel;
    }

    private function calTotalAmount($parcels)
    {
        $totals = $parcels->pluck('total', 'id');
        $amount = 0;
        foreach($totals as $id => $total) {
            $amount += removeFormatPrice($total);
        }
        return $amount;
    }

    private function parcelFileName($search)
    {
        $guest = [];
        $v = trans('label.parcel_file_begin');
        if(!empty($search['keyword'])) {
            $v .= 'keyword='.$search['keyword'];
        }
        if(!empty($search['guest_id'])) {
            $guestId = $search['guest_id'];
            $guest = $this->guestService->findById($guestId);
            $v .= '_' . data_get($guest, 'guest_code');
        }
        if(!empty($search['dates'])) {
            $range = str_replace(' to ', '-', $search['dates']);
            $v .= '_' . $range;
        }
        if(!empty($search['status'])) {
            $name = data_get(Parcel::$statusNames, $search['status']);
            $v .= '_' . $name;
        }
        $v .= '.xlsx';
        return [$v, $guest];
    }

    public function input(Request $request)
    {
        list($services, $services_display) = $this->parcelService->getServiceList();
        $cal_remote = 0;
        if (old('province') && old('district')) {
            $cal_remote = Parcel::isCalRemote(old('province'), old('district'));
        }
        $val_pack_in = 0;
        $old_services = json_encode($services);
        if (!empty(old('services'))) {
            $old_services = stringify2array(old('services'));
            $pack_in = array_first(array_where($old_services, function($v, $k){
                return data_get($v, 'key') == 'package_in';
            }));
            $val_pack_in = data_get($pack_in, 'value');
        }

        $last_parcel_guest = $this->parcelService->getLastGuest();
        $data = [
            'cal_remote'       => $cal_remote,
            'last_guest'       => data_get($last_parcel_guest, 'id', -999),
            'guests'           => $this->parcelService->guestList(),
            'services'         => $old_services,
            'val_pack_in'      => $val_pack_in,
            'services_display' => $services_display,
            'default'          => config('setting.default'),
            'provincials'      => $this->parcelService->getProvincials(),
            'districts'        => $this->parcelService->getDistrictByProvinceId(old('province')),
            'wards'            => $this->parcelService->getWardsByDistrictId(old('district')),
            'parcel_types'     => $this->parcelService->getParcelTypes(),
            'transfer_types'   => $this->parcelService->getTransferTypes(),
        ];
        return view('admin.parcel.input', $data);
    }

    public function create(CreateParcel $request)
    {
        $data = $request->only(['bill_code', 'guest_id', 'guest_code', 'receiver', 'receiver_tel', 'receiver_company', 'value_declare', 'province', 'district', 'ward', 'address', 'type', 'weight', 'real_weight', 'long', 'wide', 'height', 'num_package', 'type_transfer', 'time_receive', 'total_service', 'services', 'price', 'cod', 'refund', 'forward', 'vat', 'price_vat', 'support_gas_rate', 'support_gas', 'support_remote_rate', 'support_remote', 'total', 'note']);
        list($result, $message) = $this->parcelService->newParcel($data);
        if ($result !== false) {
            session()->flash('success', trans('message.create_parcel_success'));
            return redirect()->route('create.parcel.complete');
        }
        session()->flash('error', $message);
        return redirect()->route('parcel.input')->withInput();
    }

    public function complete()
    {
        $data['message'] = session()->has('success') ? session()->get('success') : 'Complete';
        return view('admin.parcel.complete', $data);
    }

    public function edit(Request $request, $id = null)
    {
        list($services, $services_display) = $this->parcelService->getServiceList();
        $parcel = $this->parcelService->findById($id);
        $transfered = $parcel->transfered->first();
        if (old('province') && old('district')) {
            $cal_remote = Parcel::isCalRemote(old('province'), old('district'));
        } else {
            $cal_remote = Parcel::isCalRemote($parcel->provincial, $parcel->district);
        }
        $old_services = json_encode($services);
        $val_pack_in = '';
        $input_services = !empty(old('services')) ? stringify2array(old('services')) : json_decode($parcel->services, true);
        if (!empty($input_services)) {
            $old_services = !empty(old('services')) ? old('services') : $parcel->services;
            $pack_in = array_first(array_where($input_services, function($v, $k){
                return data_get($v, 'key') == 'package_in';
            }));
            $val_pack_in = data_get($pack_in, 'value');
        }
        //get params in path
        $varsIndex = $request->only($this->varsIndexKeys);
        $data = [
            'varsIndex'        => $varsIndex,
            'cal_remote'       => $cal_remote,
            'parcel'           => $parcel,
            'transfered'       => $transfered,
            'guests'           => $this->parcelService->guestList(),
            'services'         => $old_services,
            'val_pack_in'      => $val_pack_in,
            'services_display' => $services_display,
            'default'          => config('setting.default'),
            'provincials'      => $this->parcelService->getProvincials(),
            'districts'        => $this->parcelService->getDistrictByProvinceId(old('province', data_get($parcel, 'provincial'))),
            'wards'            => $this->parcelService->getWardsByDistrictId(old('district', data_get($parcel, 'district'))),
            'parcel_types'     => $this->parcelService->getParcelTypes(),
            'transfer_types'   => $this->parcelService->getTransferTypes(),
        ];
        return view('admin.parcel.edit', $data);
    }

    public function update(CreateParcel $request, $id = null)
    {
        $data = $request->only(['bill_code', 'guest_id', 'guest_code', 'receiver', 'receiver_tel', 'receiver_company', 'value_declare', 'province', 'district', 'ward', 'address', 'type', 'weight', 'real_weight', 'long', 'wide', 'height', 'num_package', 'type_transfer', 'time_receive', 'total_service', 'services', 'price', 'cod', 'refund', 'forward', 'vat', 'price_vat', 'support_gas_rate', 'support_gas', 'support_remote_rate', 'support_remote', 'total', 'note', 'transfered', 'index']);
        list($result, $message) = $this->parcelService->updateParcel($data, $id);
        if ($result !== false) {
            $varsIndex = $request->only(['index']);
            session()->flash('success', trans('message.update_parcel_success'));
            return redirect()->route('parcel')->withInput(data_get($varsIndex, 'index'));
        }
        session()->flash('error', $message);
        return redirect()->route('parcel.edit', $id)->withInput();
    }

    public function delete(Request $request, $id = null)
    {
        list($result, $msg) = $this->parcelService->deleteParcel($id);
        if ($result === false) {
            session()->flash('error', $msg);
        } else {
            session()->flash('success', trans('message.delete_parcel_success'));
        }
        $varsIndex = $request->only($this->varsIndexKeys);
        return redirect()->route('parcel')->withInput($varsIndex);
    }

    public function ajaxGetDistricts($provinceId = null) 
    {
        $districts = $this->parcelService->getDistrictByProvinceId($provinceId);
        return response()->json($districts);
    }

    public function ajaxGetWards(Request $request, $districtId = null) 
    {
        $wards = $this->parcelService->getWardsByDistrictId($districtId);
        return response()->json($wards);
    }

    public function ajaxCalculatePrice(Request $request)
    {
        $info = $request->only(['province', 'district', 'ward', 'guest', 'service_type', 'weight', 'real_weight', 'parcel', 'forward']);
        if (empty($info['service_type']) || empty($info['weight']) || empty($info['province']) || empty($info['district'])) {
            return response()->json(['price' => 0, 'error' => 'invalid params']);
        }
        $parcel_id = data_get($info, 'parcel');
        //identify calculate remote
        $province = $info['province'];
        $district = $info['district'];

        $filePrice = data_get($info, 'service_type') == config('setting.transfer_type.code.transport') ? 'delivery_price' : 'quick_price';
        //get setting price
        $setting = config('price.'.$filePrice);
        $weight_by = data_get($setting, 'weight_by');

        //transform weight
        $weight = data_get($info, 'weight');
        if ($weight_by == 'gram') {
            $weight = $weight * 1000;//base front-end is kg
        }
        $define  = data_get($setting, 'define');
        $km_type = self::getPriceKmDefine($province, $define, $parcel_id);

        $prices = data_get($setting, 'price');
        $cal_info = self::calculatePrice($km_type, $weight, $prices);
        if (Parcel::isCalRemote($province, $district)) {
            $cal_info['cal_remote'] = true;
        }
        return response()->json(array_merge($cal_info, [
            'km_type' => $km_type,
            'province' => $province,
        ]));
    }

    private function calculatePrice($km_type, $weight, array $prices)
    {
        $base = data_get($prices, 'base');
        if (empty($base)) {
            return [
                'error' => 'not have base price info',
                'total_base' => 0,
                'total_format' => 0,
            ];
        }
        $price = 0;
        $calculated = 0;
        foreach ($base as $weight_range => $base_price) {
            $price = data_get($base_price, $km_type);
            //range
            list($floor, $ceil) = explode('-', $weight_range);
            if ($weight >= $floor && $weight <= $ceil) {
                $calculated += ($weight - $floor);
                return [
                    'weight' => [
                        'base' => $calculated,
                        'over' => 0,
                    ],
                    'price' => [
                        'base' => formatPrice($price),
                        'over' => 0,
                    ],
                    'total_base' => $price,
                    'total_format' => formatPrice($price),
                ];
            }
            $calculated += ($ceil - $floor);
        }
        $over = $weight - $calculated;
        // dd($km_type, $weight, $calculated, $over, $price);
        // every over weight will be multiple with price
        $every = data_get($prices, 'above.every');
        $ranges = data_get($prices, 'above.range', []);
        if (empty($every) || empty($ranges)) {
            return [
                'weight' => [
                    'base' => $calculated,
                    'over' => 0,
                ],
                'price' => [
                    'base' => formatPrice($price),
                    'over' => 0,
                ],
                'total_base' => $price,
                'total_format' => formatPrice($price),
                'over_history' => [],
            ];
        }

        $total_over = 0;
        $run = 0;
        $over_history = [];
        $over_level = self::calOverLevel($over, $ranges);
        foreach ($ranges as $weight_range => $overs) {
            if ($run == $over_level) {
                break;
            }
            list($floor, $ceil) = explode('-', $weight_range);
            $over_price = data_get($overs, $km_type);
            $over_history[] = [
                'weight_range' => $weight_range,
                'prices'       => $overs,
                'floor'        => $floor,
                'ceil'         => $ceil,
            ];
            // find weight apply for price_range
            if ($over >= $floor && ($over <= $ceil || $ceil == '~')) {
                $over_weight = $over - $floor;
            } else {
                $over_weight = $ceil - $floor;
            }
            $times_over = ceil($over_weight/$every);
            $total_over += ($times_over * $over_price);
            $run++;
        }
        $total_amount = $price + $total_over;
        return [
            'weight' => [
                'base' => $calculated,
                'over' => $over,
            ],
            'price' => [
                'base' => formatPrice($price),
                'over' => formatPrice($total_over),
            ],
            'total_base'   => $total_amount,
            'total_format' => formatPrice($total_amount),
            'over_history' => $over_history,
            'total_over'   => $total_over,
            'over_level'   => $over_level,
            'km_type'      => $km_type,
        ];
    }

    private function calOverLevel($over, $ranges)
    {
        $over_level = 1;
        foreach ($ranges as $weight_range => $overs) {
            list($floor, $ceil) = explode('-', $weight_range);
            if ($ceil == '~') {
                $ceil = '9999999999';
            }
            if ($over >= $floor && $over <= $ceil) {
                break;
            }
            $over_level++;
        }
        return $over_level;
    }

    private function getPriceKmDefine($province, array $define, $parcel_id = null)
    {
        if (!empty($parcel_id)) {
            //@TODO
            //case forward
            //find info parcel destination
            //cal destination from last destination to new
            //@confirmed - use cal like first time
        }
        $last_key = array_key_last($define);
        array_pop($define);
        foreach ($define as $key => $list) {
            if (in_array($province, $list)) {
                return $key;
            }
        }
        return $last_key;
    }
}