<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('user.home.index');
    }

    public function about(Request $request)
    {
        return view('user.home.about');
    }

    public function contact(Request $request)
    {
        return view('user.home.contact');
    }

    public function category(Request $request)
    {
        return view('user.home.category');
    }

    public function blog(Request $request)
    {
        return view('user.home.blog-single');
    }
}