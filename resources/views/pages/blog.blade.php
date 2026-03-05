@extends('layouts.main')

@section('title', 'Yukinova| Latest Battery Insights')

@section('description', '')

@section('keywords', '')

@section('content')

<div class="main-wrapper">

    <div class="page-banner-blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Blogs</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="blog-wrapper section-entry">
        <div class="container">
            <div class="row">
                @foreach ($blogs as $item)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">

                    <a href="{{ route('details.detail', $item->slug) }}" class="blog-link">
                        <div class="blog-card">

                            <div class="blog-img">
                                <img src="{{ asset('storage/blog/' . $item->featured_image) }}"
                                    alt="{{ $item->post_title }}">
                                <span class="blog-date">
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                            </div>

                            <div class="blog-content">
                                <h5 class="blog-title">
                                    {{ \Illuminate\Support\Str::limit($item->post_title,60) }}
                                </h5>

                                <p class="blog-excerpt">
                                    {{ \Illuminate\Support\Str::words(strip_tags($item->blog_post), 18) }}
                                </p>

                                <span class="read-more">
                                    Read More →
                                </span>
                            </div>

                        </div>
                    </a>
                </div>

                @endforeach
            </div>

        </div>
    </div>
</div>


@endsection