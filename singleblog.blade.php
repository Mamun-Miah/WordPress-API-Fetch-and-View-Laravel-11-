@extends('layouts.frontend.app')

@section('title', $post['title']['rendered'])

@section('content')
    <div class="max-w-4xl mx-auto my-12 p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-4xl font-bold mb-6">{!! $post['title']['rendered'] !!}</h1>
        <img src="{{ $post['featured_image'] }}" alt="{{ $post['title']['rendered'] }}" class="w-full mb-6 rounded-lg">
        <div class="prose lg:prose-xl">
            {!! $post['content']['rendered'] !!}
        </div>
        <div class="mt-6">
            <a href="{{ url('/') }}" class="text-blue-500 hover:underline">← Back to Blog</a>
        </div>
    </div>
@endsection
