<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GuestService;
use App\Services\ParcelService;
use App\Request\Admin\CreateGuest;

class GuestController extends Controller
{
    private $parcelService;
    private $guestService;

    public function __construct(GuestService $guestService, ParcelService $parcelService)
    {
        $this->guestService = $guestService;
        $this->parcelService = $parcelService;
    }

    public function index(Request $request)
    {
        $search = ['keyword' => $request->keyword];
        $data = [
            'user'   => $request->user(),
            'search' => $search,
            'guests' => $this->guestService->getList($search),
        ];
        return view('admin.guest.index', $data);
    }

    public function input(Request $request)
    {
        $data = [
            'provincials' => $this->parcelService->getProvincials(),
        ];
        return view('admin.guest.input', $data);
    }

    public function create(CreateGuest $request)
    {
        dd('guest create');
    }
}
