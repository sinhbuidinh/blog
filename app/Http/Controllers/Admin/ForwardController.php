<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ForwardService;

class ForwardController extends Controller
{
    public function index(Request $request)
    {
        dd('forward index');
    }
}