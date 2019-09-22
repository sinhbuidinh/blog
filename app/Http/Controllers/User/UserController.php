<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use View;

class UserController extends Controller
{
    public function __construct()
    {
        View::share('headers', self::getSlider());
    }

    private function getSlider()
    {
        return [
            [
                'img' => 'user/slider1.jpg',
                'alt' => 'slider1 kn247',
                'title' => 'KN247',
                'caption' => 'Tin cậy như bạn tự tay chuyển phát',
            ],
            [
                'img' => 'user/slider2.jpg',
                'alt' => 'slider2 kn247',
                'title' => 'KN247',
                'caption' => 'Nhanh chóng, tiện lợi',
            ],
            [
                'img' => 'user/slider3.jpg',
                'alt' => 'slider3 kn247',
                'title' => 'KN247',
                'caption' => 'Thân thiện, gần gũi',
            ],
        ];
    }
}