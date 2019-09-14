<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ParcelService;
use View;

class HomeController extends Controller
{
    private $parcelService;
    public function __construct(ParcelService $parcelService)
    {
        $this->parcelService = $parcelService;
        View::share('headers', self::getSlider());
    }

    public function index(Request $request)
    {
        $data = [
            'categories' => $this->getCategories(),
            'popular_post'  => $this->getPopularPost(),
        ];
        return view('user.home.index', $data);
    }

    public function locate(Request $request, $code = null)
    {
        $parcel = $histories = $tracks = [];
        if (!empty($code)) {
            list($parcel, $histories, $tracks) = $this->parcelService->locateInfo($code);
        }
        $data = [
            'code'      => $code,
            'parcel'    => $parcel,
            'histories' => $histories,
            'tracks'    => $tracks,
        ];
        return view('user.home.locate', $data);
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

    public function contact(Request $request)
    {
        $categories = $this->getCategories();
        $footer_latest = array_slice($this->getLatestPost(), 0, 3);
        $popular_post = $this->getPopularPost();
        $have_suggest = true;
        return view('user.home.contact', compact('categories', 'footer_latest', 'popular_post', 'have_suggest'));
    }

    public function category(Request $request, string $type = null)
    {
        $categories = $this->getCategories();
        $footer_latest = array_slice($this->getLatestPost(), 0, 3);
        $popular_post = $this->getPopularPost();
        $category_posts = $this->getCategoriesPost();
        return view('user.home.category', compact('categories', 'type', 'footer_latest', 'popular_post', 'category_posts'));
    }

    public function blog(Request $request)
    {
        $categories = $this->getCategories();
        $footer_latest = array_slice($this->getLatestPost(), 0, 3);
        $popular_post = $this->getPopularPost();
        return view('user.home.blog-single', compact('categories', 'footer_latest', 'popular_post'));
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
                'short_body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem nobis, ut dicta eaque ipsa laudantium!',
            ],
            [
                'id' => 2,
                'image_name' => 'img_11.jpg',
                'category' => 'Lifestyle',
                'create_from' => 'Jan 1, 2018',
                'comments' => '2',
                'title' => 'Cool way for take a picture beauty',
                'short_body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem nobis, ut dicta eaque ipsa laudantium!',
            ],
            [
                'id' => 3,
                'image_name' => 'img_12.jpg',
                'category' => 'Food',
                'create_from' => 'Feb 2, 2018',
                'comments' => '4',
                'title' => 'Healthy food for life',
                'short_body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem nobis, ut dicta eaque ipsa laudantium!',
            ],
            [
                'id' => 4,
                'image_name' => 'img_9.jpg',
                'category' => 'Travel',
                'create_from' => 'Apr 5, 2018',
                'comments' => '5',
                'title' => 'Beauty of nature',
                'short_body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem nobis, ut dicta eaque ipsa laudantium!',
            ],
            [
                'id' => 5,
                'image_name' => 'img_7.jpg',
                'category' => 'Food',
                'create_from' => 'May 10, 2018',
                'comments' => '12',
                'title' => 'Organic food and beauty of art decorate',
                'short_body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem nobis, ut dicta eaque ipsa laudantium!',
            ],
            [
                'id' => 6,
                'image_name' => 'img_6.jpg',
                'category' => 'Travel',
                'create_from' => 'Jun 2, 2018',
                'comments' => '22',
                'title' => 'High moutain for fresh air',
                'short_body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem nobis, ut dicta eaque ipsa laudantium!',
            ],
            [
                'id' => 7,
                'image_name' => 'img_5.jpg',
                'category' => 'Lifestyle',
                'create_from' => 'Jul 8, 2018',
                'comments' => '9',
                'title' => 'Enjoy breakfast',
                'short_body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem nobis, ut dicta eaque ipsa laudantium!',
            ],
            [
                'id' => 8,
                'image_name' => 'img_4.jpg',
                'category' => 'Food',
                'create_from' => 'Aug 31, 2018',
                'comments' => '11',
                'title' => 'Experience for travel with street food',
                'short_body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem nobis, ut dicta eaque ipsa laudantium!',
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
                'create_from' => 'March 15, 2018',
                'comments' => '2',
            ],
            [
                'id' => 2,
                'image_name' => 'img_2.jpg',
                'title' => 'How to enjoy work',
                'create_from' => 'April 2, 2018',
                'comments' => '3',
            ],
            [
                'id' => 3,
                'image_name' => 'img_3.jpg',
                'title' => 'How to enjoy life',
                'create_from' => 'Jan 4, 2018',
                'comments' => '4',
            ],
            [
                'id' => 4,
                'image_name' => 'img_4.jpg',
                'title' => 'How to enjoy cooking',
                'create_from' => 'July 5, 2018',
                'comments' => '11',
            ],
        ];
    }

    private function getCategoriesPost()
    {
        return [
            [
                'id' => '5',
                'image_name' => 'img_4.jpg',
                'category_name' => 'Food',
                'create_from' => 'March 15, 2018',
                'comments' => '3',
                'title' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
            ],
            [
                'id' => '6',
                'image_name' => 'img_5.jpg',
                'category_name' => 'Lifestyle',
                'create_from' => 'March 15, 2018',
                'comments' => '4',
                'title' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
            ],
            [
                'id' => '7',
                'image_name' => 'img_6.jpg',
                'category_name' => 'Travel',
                'create_from' => 'March 15, 2018',
                'comments' => '6',
                'title' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
            ],
            [
                'id' => '8',
                'image_name' => 'img_7.jpg',
                'category_name' => 'Food',
                'create_from' => 'March 12, 2018',
                'comments' => '5',
                'title' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
            ],
            [
                'id' => '9',
                'image_name' => 'img_8.jpg',
                'category_name' => 'Lifestyle',
                'create_from' => 'Jun 12, 2018',
                'comments' => '9',
                'title' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
            ],
            [
                'id' => '11',
                'image_name' => 'img_9.jpg',
                'category_name' => 'Travel',
                'create_from' => 'July 12, 2018',
                'comments' => '1',
                'title' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
            ],
            [
                'id' => '10',
                'image_name' => 'img_10.jpg',
                'category_name' => 'Travel',
                'create_from' => 'Jan 23, 2018',
                'comments' => '11',
                'title' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
            ],
            [
                'id' => '12',
                'image_name' => 'img_11.jpg',
                'category_name' => 'Lifestyle',
                'create_from' => 'Jan 23, 2018',
                'comments' => '8',
                'title' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
            ],
            [
                'id' => '13',
                'image_name' => 'img_12.jpg',
                'category_name' => 'Food',
                'create_from' => 'Jan 6, 2018',
                'comments' => '6',
                'title' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
            ],
        ];
    }

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
}