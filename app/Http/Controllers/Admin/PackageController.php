<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PackageService;

class PackageController extends Controller
{
    public function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
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
}