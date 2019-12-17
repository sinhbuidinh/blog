<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrintController extends Controller
{
    public function debt(Request $request)
    {
        $barcodeService = new App\Services\BarcodeService();
        list($barcode, $code) = $barcodeService->genBarCode(BarcodeService::BARCODE_TYPE);
        $data = [
            'barcode' => $barcode,
            'code' => $code,
        ];
        return view('admin.print.debt', $data);
    }
}
