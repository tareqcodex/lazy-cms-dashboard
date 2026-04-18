<?php

namespace Acme\CmsDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Acme\CmsDashboard\Models\Post;
use Acme\CmsDashboard\Models\PostType;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Show a post content.
     * This handles /{slug} or /{type}/{slug}
     */
    public function show($typeOrSlug, $slug = null)
    {
        if ($slug) {
            // Handle /{type}/{slug}
            $type = $typeOrSlug;
            $postSlug = $slug;
            
            $postType = PostType::where('slug', $type)->first();
            if (!$postType || !$postType->is_public) {
                abort(404);
            }
            
            $post = Post::where('type', $type)
                ->where('slug', $postSlug)
                ->where('status', 'published')
                ->firstOrFail();
        } else {
            // Handle /{slug} - could be a Page or a Post
            $postSlug = $typeOrSlug;
            
            $post = Post::where('slug', $postSlug)
                ->where('status', 'published')
                ->first();
                
            if (!$post) {
                abort(404);
            }
            
            $postType = $post->postTypeDefinition;
            if ($postType && !$postType->is_public) {
                 abort(404);
            }
        }

        return "<h1>" . e($post->title) . "</h1><div>" . $post->content . "</div>";
    }
}
