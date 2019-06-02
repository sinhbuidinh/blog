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
        $footer_latest = array_slice($this->getLatestPost(), 0, 3);
        $popular_post = $this->getPopularPost();
        return view('user.home.index', compact('categories', 'footer_latest', 'popular_post'));
    }

    public function about(Request $request)
    {
        $categories = $this->getCategories();
        $without_slider = true;
        $without_sidebar = true;
        $all_latest_post = $this->getLatestPost();
        $footer_latest = array_slice($all_latest_post, 0, 3);
        return view('user.home.about', compact('categories', 'without_slider', 'without_sidebar', 'all_latest_post', 'footer_latest'));
    }

    private function getLatestPost()
    {
        return [
            [
                'id' => 1,
                'image_name' => 'img_10.jpg',
                'category' => 'Travel',
                'create_from' => 'Mar 15, 2018',
                'comments' => '3',
                'title' => 'Beauty highlight from rope bridge',
            ],
            [
                'id' => 2,
                'image_name' => 'img_11.jpg',
                'category' => 'Lifestyle',
                'create_from' => 'Jan 1, 2018',
                'comments' => '2',
                'title' => 'Cool way for take a picture beauty',
            ],
            [
                'id' => 3,
                'image_name' => 'img_12.jpg',
                'category' => 'Food',
                'create_from' => 'Feb 2, 2018',
                'comments' => '4',
                'title' => 'Healthy food for life',
            ],
            [
                'id' => 4,
                'image_name' => 'img_9.jpg',
                'category' => 'Travel',
                'create_from' => 'Apr 5, 2018',
                'comments' => '5',
                'title' => 'Beauty of nature',
            ],
            [
                'id' => 5,
                'image_name' => 'img_7.jpg',
                'category' => 'Food',
                'create_from' => 'May 10, 2018',
                'comments' => '12',
                'title' => 'Organic food and beauty of art decorate',
            ],
            [
                'id' => 6,
                'image_name' => 'img_6.jpg',
                'category' => 'Travel',
                'create_from' => 'Jun 2, 2018',
                'comments' => '22',
                'title' => 'High moutain for fresh air',
            ],
            [
                'id' => 7,
                'image_name' => 'img_5.jpg',
                'category' => 'Lifestyle',
                'create_from' => 'Jul 8, 2018',
                'comments' => '9',
                'title' => 'Enjoy breakfast',
            ],
            [
                'id' => 8,
                'image_name' => 'img_4.jpg',
                'category' => 'Food',
                'create_from' => 'Aug 31, 2018',
                'comments' => '11',
                'title' => 'Experience for travel with street food',
            ],
        ];
    }

    private function getPopularPost()
    {
        return [
            [
                'id' => 1,
                'image_name' => 'img_1.jpg',
                'title' => 'Travel with me',
                'date_from' => 'March 15, 2018',
                'comments' => '2',
            ],
            [
                'id' => 2,
                'image_name' => 'img_2.jpg',
                'title' => 'How to enjoy work',
                'date_from' => 'April 2, 2018',
                'comments' => '3',
            ],
            [
                'id' => 3,
                'image_name' => 'img_3.jpg',
                'title' => 'How to enjoy life',
                'date_from' => 'Jan 4, 2018',
                'comments' => '4',
            ],
            [
                'id' => 4,
                'image_name' => 'img_4.jpg',
                'title' => 'How to enjoy cooking',
                'date_from' => 'July 5, 2018',
                'comments' => '11',
            ],
        ];
    }

    public function contact(Request $request)
    {
        $categories = $this->getCategories();
        $have_suggest = false;
        $footer_latest = array_slice($this->getLatestPost(), 0, 3);
        $popular_post = $this->getPopularPost();
        return view('user.home.contact', compact('have_suggest', 'categories', 'footer_latest', 'popular_post'));
    }

    public function category(Request $request, string $type = null)
    {
        $categories = $this->getCategories();
        $footer_latest = array_slice($this->getLatestPost(), 0, 3);
        $popular_post = $this->getPopularPost();
        return view('user.home.category', compact('categories', 'type', 'footer_latest', 'popular_post'));
    }

    public function blog(Request $request)
    {
        $categories = $this->getCategories();
        $footer_latest = array_slice($this->getLatestPost(), 0, 3);
        $popular_post = $this->getPopularPost();
        return view('user.home.blog-single', compact('categories', 'footer_latest', 'popular_post'));
    }
}