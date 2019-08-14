<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PackageService;
use App\Services\ParcelService;

class PackageController extends Controller
{
    private $packageService;
    private $parcelService;

    public function __construct(PackageService $packageService, ParcelService $parcelService)
    {
        $this->packageService = $packageService;
        $this->parcelService = $parcelService;
    }

    public function index(Request $request)
    {
        $search = ['keyword' => $request->keyword];
        $data = [
            'user'     => $request->user(),
            'search'   => $search,
            'packages' => $this->packageService->getList($search),
        ];
        return view('admin.package.index', $data);
    }

    public function input(Request $request)
    {
        $data = [
            'parcels' => $this->parcelService->getListForPackage(),
        ];
        return view('admin.package.input', $data);
    }
}