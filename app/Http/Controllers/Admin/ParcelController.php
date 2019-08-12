<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ParcelService;
use App\Request\Admin\CreateParcel;
use App\Models\Parcel;

class ParcelController extends Controller
{
    public function __construct(ParcelService $parcelService)
    {
        $this->parcelService = $parcelService;
    }

    public function index(Request $request)
    {
        $search = ['keyword' => $request->keyword];
        $data = [
            'user' => $request->user(),
            'search' => $search,
            'parcels' => $this->parcelService->getList($search),
        ];
        return view('admin.parcel.index', $data);
    }

    public function input(Request $request)
    {
        list($services, $services_display) = $this->parcelService->getServiceList();
        $cal_remote = 0;
        if (old('province') && old('district')) {
            $cal_remote = Parcel::isCalRemote(old('province'), old('district'));
        }
        $data = [
            'cal_remote'       => $cal_remote,
            'guests'           => $this->parcelService->guestList(),
            'services'         => $services,
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
        $data = $request->only(['bill_code', 'guest_id', 'guest_code', 'receiver', 'receiver_tel', 'province', 'district', 'ward', 'address', 'type', 'weight', 'real_weight', 'long', 'wide', 'height', 'num_package', 'type_transfer', 'time_receive', 'total_service', 'services', 'price', 'cod', 'refund', 'forward', 'vat', 'price_vat', 'support_gas_rate', 'support_gas', 'support_remote_rate', 'support_remote', 'total', 'note']);
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
        if (old('province') && old('district')) {
            $cal_remote = Parcel::isCalRemote(old('province'), old('district'));
        } else {
            $cal_remote = Parcel::isCalRemote($parcel->provincial, $parcel->district);
        }
        $data = [
            'cal_remote'       => $cal_remote,
            'parcel'           => $parcel,
            'guests'           => $this->parcelService->guestList(),
            'services'         => $services,
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
        $data = $request->only(['bill_code', 'guest_id', 'guest_code', 'receiver', 'receiver_tel', 'province', 'district', 'ward', 'address', 'type', 'weight', 'real_weight', 'long', 'wide', 'height', 'num_package', 'type_transfer', 'time_receive', 'total_service', 'services', 'price', 'cod', 'refund', 'forward', 'vat', 'price_vat', 'support_gas_rate', 'support_gas', 'support_remote_rate', 'support_remote', 'total', 'note']);
        list($result, $message) = $this->parcelService->updateParcel($data, $id);
        if ($result !== false) {
            session()->flash('success', trans('message.update_parcel_success'));
            return redirect()->route('create.parcel.complete');
        }
        session()->flash('error', $message);
        return redirect()->route('parcel.edit', $id)->withInput();
    }

    public function delete(Request $request, $id = null)
    {
        $parcel = $this->parcelService->findById($id);
        $parcel->delete();
        session()->flash('success', trans('message.delete_parcel_success'));
        return redirect()->route('parcel');
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
        $info = $request->only(['province', 'district', 'ward', 'guest', 'service_type', 'weight', 'real_weight']);
        if (empty($info['service_type']) || empty($info['province']) || empty($info['weight'])) {
            return response()->json(['price' => 0, 'error' => 'invalid params']);
        }
        //identify calculate remote
        $province = $info['province'];
        $district = $info['district'];

        $filePrice = $info['service_type'] == config('setting.transfer_type.code.transport') ? 'delivery_price' : 'quick_price';
        //get setting price
        $setting = config('price.'.$filePrice);
        $weight_by = data_get($setting, 'weight_by');

        //transform weight
        $weight = $info['weight'];
        if ($weight_by == 'gram') {
            $weight = $weight * 1000;//base front-end is kg
        }
        $define  = data_get($setting, 'define');
        $km_type = self::getPriceKmDefine($province, $define);

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
            $price += data_get($base_price, $km_type);
            //range
            list($floor, $ceil) = explode('-', $weight_range);
            if ($weight <= $ceil && $weight >= $floor) {
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
        // get setting above
        $above = data_get($prices, 'above');

        // every over weight will be multiple with price
        $every = data_get($above, 'every');
        $ranges = data_get($above, 'range', []);
        $total_over = 0;
        $over_history = [];
        foreach ($ranges as $weight_range => $overs) {
            list($floor, $ceil) = explode('-', $weight_range);
            $over_price = data_get($overs, $km_type);
            // find weight apply for price_range
            if ($ceil == '~') {
                $over_weight = $over;
            } else {
                if ($over >= $floor && $over <= $ceil) {
                    $over_weight = $over - $floor;
                } else {
                    $over_weight = $ceil - $floor;
                }
            }
            // time over for apply price of range
            $times_over = ceil($over_weight/$every);
            $total_over += ($times_over * $over_price);
            $over_history[] = [
                'weight_range' => $weight_range,
                'prices'       => $overs,
                'over_weight'  => $over_weight,
                'floor'        => $floor,
                'ceil'         => $ceil,
                'times_over'   => $times_over,
                'total_over'   => $total_over,
            ];
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
            'total_base' => $total_amount,
            'total_format' => formatPrice($total_amount),
            'over_history' => $over_history,
        ];
    }

    private function getPriceKmDefine($province, array $define)
    {
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