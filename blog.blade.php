@extends('layouts.frontend.app')

@section('title', 'Maple Service Solution Limited')

@section('content')
    <h1 class="text-center my-24 text-5xl font-bold">Latest Blog Posts</h1>
    <div class="grid grid-cols-3 gap-8 mx-16">
        @foreach ($posts as $post)
            <div class="card bg-base-100 shadow-xl">
                <figure>
                    <!-- Use the correct image URL from the _embedded field or a placeholder if not available -->
                    <img src="{{ $post['_embedded']['wp:featuredmedia'][0]['source_url'] ?? 'https://placehold.co/600x400' }}"
                        alt="{{ $post['title']['rendered'] }}" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title">{!! $post['title']['rendered'] !!}</h2>
                    <!-- Limiting the excerpt text to avoid overflow and showing a summary -->
                    <p>{!! Str::limit(strip_tags($post['excerpt']['rendered']), 130) !!}</p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-sm btn-primary">
                            <a href="{{ route('blog.show', $post['slug']) }}">Read Blog</a>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
