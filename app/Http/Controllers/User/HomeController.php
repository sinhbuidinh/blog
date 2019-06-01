<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function getCategories()
    {
        return [
            'code' => [
                'route_name' => 'user.category',
                'route_params' => ['type' => 'code'],
                'route'  => route('user.category', ['type' => 'code']),
                'name'   => 'Coding',
                'count' => 12,
            ],
            'food' => [
                'route_name' => 'user.category',
                'route_params' => ['type' => 'food'],
                'route'  => route('user.category', ['type' => 'food']),
                'name'   => 'Food',
                'count' => 21,
            ],
            'travel' => [
                'route_name' => 'user.category',
                'route_params' => ['type' => 'travel'],
                'route'  => route('user.category', ['type' => 'travel']),
                'name'   => 'Travel',
                'count' => 7,
            ],
            'life' => [
                'route_name' => 'user.category',
                'route_params' => ['type' => 'life'],
                'route'  => route('user.category', ['type' => 'life']),
                'name'   => 'Lifestyle',
                'count' => 15,
            ],
        ];
    }

    public function index(Request $request)
    {
        $categories = $this->getCategories();
        return view('user.home.index', compact('categories'));
    }

    public function about(Request $request)
    {
        $categories = $this->getCategories();
        $without_slider = true;
        $without_sidebar = true;
        return view('user.home.about', compact('categories', 'without_slider', 'without_sidebar'));
    }

    public function contact(Request $request)
    {
        $categories = $this->getCategories();
        $have_suggest = false;
        return view('user.home.contact', compact('have_suggest', 'categories'));
    }

    public function category(Request $request, string $type = null)
    {
        $categories = $this->getCategories();
        return view('user.home.category', compact('categories', 'type'));
    }

    public function blog(Request $request)
    {
        $categories = $this->getCategories();
        return view('user.home.blog-single', compact('categories'));
    }
}