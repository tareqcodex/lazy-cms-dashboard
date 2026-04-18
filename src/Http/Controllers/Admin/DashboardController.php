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
        // For now, using some mock data for hits since tracking isn't fully implemented
        // But we can get real counts for posts/pages
        $stats = [
            'total_hits' => 12543, // Mock
            'active_visitors' => 42, // Mock
            'top_pages' => [
                ['title' => 'Home Page', 'views' => 4500],
                ['title' => 'About Us', 'views' => 1200],
                ['title' => 'Services', 'views' => 850],
                ['title' => 'Contact', 'views' => 400],
            ],
            'counts' => [
                'posts' => Post::count(),
                'pages' => Page::count(),
                'media' => Media::count(),
            ]
        ];

        return view('cms-dashboard::admin.dashboard', compact('stats'));
    }
}
