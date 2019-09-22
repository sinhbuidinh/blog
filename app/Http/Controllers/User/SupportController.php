<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Services\SupportService;

class SupportController extends UserController
{
    private $supportService;
    public function __construct(SupportService $supportService)
    {
        parent::__construct();
        $this->supportService = $supportService;
    }

    public function fullTimeCourse(Request $request)
    {
        $data = [];
        return view('user.support.full-time', $data);
    }

    public function priceTbl(Request $request)
    {
        $data = [];
        return view('user.support.price-tbl', $data);
    }

    public function gasAndExchange(Request $request)
    {
        $data = [];
        return view('user.support.gas-exchange', $data);
    }

    public function vat(Request $request)
    {
        $data = [];
        return view('user.support.vat', $data);
    }
}