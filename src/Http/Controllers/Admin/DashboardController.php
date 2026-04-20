<?php

namespace Acme\CmsDashboard\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Acme\CmsDashboard\Models\Post;
use Acme\CmsDashboard\Models\Page;
use Acme\CmsDashboard\Models\Media;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'client_rating' => [
                'score' => '7.8/10',
                'change' => '+20%',
                'label' => 'Avg. Client Rating'
            ],
            'instagram_followers' => [
                'count' => '5,934',
                'change' => '-3.59%',
                'label' => 'Instagram Followers'
            ],
            'total_revenue' => [
                'amount' => '$9,758',
                'change' => '+15%',
                'label' => 'Total Revenue'
            ],
            'traffic_stats' => [
                'new_subscribers' => [
                    'value' => '567K',
                    'change' => '+3.85%',
                    'data' => [40, 45, 42, 48, 50, 48, 52]
                ],
                'conversion_rate' => [
                    'value' => '276K',
                    'change' => '-5.39%',
                    'data' => [30, 28, 32, 29, 31, 33, 30]
                ],
                'bounce_rate' => [
                    'value' => '285',
                    'change' => '+12.74%',
                    'data' => [50, 52, 48, 55, 53, 51, 54]
                ]
            ],
            'main_chart' => [
                'labels' => ['Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'data1' => [200, 210, 215, 230, 225],
                'data2' => [100, 110, 120, 150, 140]
            ],
            'counts' => [
                'posts' => Post::count(),
                'pages' => Page::count(),
                'media' => Media::count(),
            ],
            'recent_posts' => Post::latest()->take(5)->get(),
        ];

        return view('cms-dashboard::admin.dashboard', compact('stats'));
    }
}
