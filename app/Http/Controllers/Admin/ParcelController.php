<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ParcelService;

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
        $data = [
            'guests'           => $this->parcelService->guestList(),
            'services'         => $services,
            'services_display' => $services_display,
            'default'          => config('setting.default'),
        ];
        // dd($services, $services_display);
        // dd($data['default']);
        return view('admin.parcel.input', $data);
    }

    public function create(Request $request)
    {
        dd('parcel create');
        //valid => back index
        //invalid => view input with error
    }
}