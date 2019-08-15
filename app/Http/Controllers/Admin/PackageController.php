<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PackageService;
use App\Services\ParcelService;
use App\Request\Admin\CreatePackage;

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

    public function create(CreatePackage $request)
    {
        $data = $request->only(['parcel']);
        list($result, $message) = $this->packageService->newPackage($data);
        if ($result !== false) {
            session()->flash('success', trans('message.create_package_success'));
            return redirect()->route('create.package.complete');
        }
        session()->flash('error', $message);
        return redirect()->route('package.input')->withInput();
    }

    public function complete()
    {
        $data['message'] = session()->has('success') ? session()->get('success') : 'Complete';
        return view('admin.package.complete', $data);
    }

    public function delete(Request $request, $id = null)
    {
        $package = $this->packageService->findById($id);
        $package->delete();
        session()->flash('success', trans('message.delete_package_success'));
        return redirect()->route('package');
    }

    public function transfer(Request $request, $id = null)
    {
        list($result, $message) = $this->packageService->updateTransfer($id);
        if ($result === false) {
            session()->flash('error', $message ?: trans('message.update_transfer_error'));
        } else {
            session()->flash('success', trans('message.update_transfer_success'));
        }
        return redirect()->route('package');
    }
}