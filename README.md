**\#BlogController fetch data**  
\<?php

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;

class BlogController extends Controller  
{  
    public function index()  
    {  
        // Fetch WordPress posts with embedded media  
        $json \= file\_get\_contents('https://mapleitfirm.com/wp-json/wp/v2/posts?\_embed');  
        $posts \= json\_decode($json, true);

        // Loop through posts to extract featured images  
        foreach ($posts as &$post) {  
            // Check if the post has a featured image in the '\_embedded' field  
            if (isset($post\['\_embedded'\]\['wp:featuredmedia'\]\[0\]\['source\_url'\])) {  
                $post\['featured\_image'\] \= $post\['\_embedded'\]\['wp:featuredmedia'\]\[0\]\['source\_url'\];  
            } else {  
                // Default image if no featured image is found  
                $post\['featured\_image'\] \= asset('images/default-image.jpg');  
            }  
        }

        // Return the view with posts and images  
        return view('blog', compact('posts'));  
    }  
    public function show($slug)  
    {  
        // Fetch posts with embedded media  
        $json \= file\_get\_contents("https://mapleitfirm.com/wp-json/wp/v2/posts?\_embed\&slug={$slug}");  
        $posts \= json\_decode($json, true);  
      
        // Check if any post is returned (WordPress API returns an array)  
        if (\!$posts || empty($posts)) {  
            abort(404);  
        }  
      
        $post \= $posts\[0\]; // WordPress returns an array of posts, we take the first one  
      
        // Extract featured image if available  
        $post\['featured\_image'\] \= $post\['\_embedded'\]\['wp:featuredmedia'\]\[0\]\['source\_url'\] ?? asset('images/default-image.jpg');  
      
        // Return the single post view  
        return view('singleblog', compact('post'));  
    }  
      
}

**\#route**  
Route::get('/blog', \[BlogController::class, 'index'\]);  
Route::get('/{slug}', \[BlogController::class, 'show'\])-\>name('blog.show');

**\#Blog Page**

@extends('layouts.frontend.app')

@section('title', 'Maple Service Solution Limited')

@section('content')  
    \<h1 class="text-center my-24 text-5xl font-bold"\>Latest Blog Posts\</h1\>  
    \<div class="grid grid-cols-3 gap-8 mx-16"\>  
        @foreach ($posts as $post)  
            \<div class="card bg-base-100 shadow-xl"\>  
                \<figure\>  
                    \<\!-- Use the correct image URL from the \_embedded field or a placeholder if not available \--\>  
                    \<img src="{{ $post\['\_embedded'\]\['wp:featuredmedia'\]\[0\]\['source\_url'\] ?? 'https://placehold.co/600x400' }}"  
                        alt="{{ $post\['title'\]\['rendered'\] }}" /\>  
                \</figure\>  
                \<div class="card-body"\>  
                    \<h2 class="card-title"\>{\!\! $post\['title'\]\['rendered'\] \!\!}\</h2\>  
                    \<\!-- Limiting the excerpt text to avoid overflow and showing a summary \--\>  
                    \<p\>{\!\! Str::limit(strip\_tags($post\['excerpt'\]\['rendered'\]), 130\) \!\!}\</p\>  
                    \<div class="card-actions justify-end"\>  
                        \<button class="btn btn-sm btn-primary"\>  
                            \<a href="{{ route('blog.show', $post\['slug'\]) }}"\>Read Blog\</a\>  
                        \</button\>  
                    \</div\>  
                \</div\>  
            \</div\>  
        @endforeach  
    \</div\>  
@endsection

**\#Single Blog Show Page**  
@extends('layouts.frontend.app')

@section('title', $post\['title'\]\['rendered'\])

@section('content')  
    \<div class="max-w-4xl mx-auto my-12 p-6 bg-white shadow-lg rounded-lg"\>  
        \<h1 class="text-4xl font-bold mb-6"\>{\!\! $post\['title'\]\['rendered'\] \!\!}\</h1\>  
        \<img src="{{ $post\['featured\_image'\] }}" alt="{{ $post\['title'\]\['rendered'\] }}" class="w-full mb-6 rounded-lg"\>  
        \<div class="prose lg:prose-xl"\>  
            {\!\! $post\['content'\]\['rendered'\] \!\!}  
        \</div\>  
        \<div class="mt-6"\>  
            \<a href="{{ url('/') }}" class="text-blue-500 hover:underline"\>← Back to Blog\</a\>  
        \</div\>  
    \</div\>  
@endsection  
mdmamunmiah.com
