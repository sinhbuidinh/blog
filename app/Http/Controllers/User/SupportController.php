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
        $file = public_path("/price/toantrinh.xlsx");
        $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        return \Response::download($file, 'thoi-gian-toan-trinh.xlsx', $headers);
    }

    public function priceTbl(Request $request)
    {
        $file = public_path("/price/BaoGia_Goc.docx");
        $headers = ['Content-Type: application/octet-stream'];
        return \Response::download($file, 'bang-gia.docx', $headers);
    }

    public function gasAndExchange(Request $request)
    {
        return view('user.support.gas-exchange');
    }

    public function vat(Request $request)
    {
        $file = public_path("/price/GTGT.docx");
        $headers = ['Content-Type: application/octet-stream'];
        return \Response::download($file, 'bang-gia-dich-vu.docx', $headers);
    }

    public function transport(Request $request)
    {
        $file = public_path("/price/bang-gia-van-tai.xlsx");
        $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        return \Response::download($file, 'bang-gia-van-tai.xlsx', $headers);
    }
}