<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // Fetch WordPress posts with embedded media
        $json = file_get_contents('https://mapleitfirm.com/wp-json/wp/v2/posts?_embed');
        $posts = json_decode($json, true);

        // Loop through posts to extract featured images
        foreach ($posts as &$post) {
            // Check if the post has a featured image in the '_embedded' field
            if (isset($post['_embedded']['wp:featuredmedia'][0]['source_url'])) {
                $post['featured_image'] = $post['_embedded']['wp:featuredmedia'][0]['source_url'];
            } else {
                // Default image if no featured image is found
                $post['featured_image'] = asset('images/default-image.jpg');
            }
        }

        // Return the view with posts and images
        return view('blog', compact('posts'));
    }
    public function show($slug)
    {
        // Fetch posts with embedded media
        $json = file_get_contents("https://mapleitfirm.com/wp-json/wp/v2/posts?_embed&slug={$slug}");
        $posts = json_decode($json, true);
    
        // Check if any post is returned (WordPress API returns an array)
        if (!$posts || empty($posts)) {
            abort(404);
        }
    
        $post = $posts[0]; // WordPress returns an array of posts, we take the first one
    
        // Extract featured image if available
        $post['featured_image'] = $post['_embedded']['wp:featuredmedia'][0]['source_url'] ?? asset('images/default-image.jpg');
    
        // Return the single post view
        return view('singleblog', compact('post'));
    }
    
}
