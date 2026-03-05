@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="admin-blog-wrapper section-entry">
            <div class="container-fluid">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0">Blog Posts</h2>
                    <a href="{{ route('blog.create') }}" class="btn btn-submit">
                        <i class="fas fa-plus me-1"></i> Create Blog
                    </a>
                </div>

                {{-- BLOG LIST --}}
                <div class="row g-4">

                    @forelse ($blogs as $blog)
                        <div class="col-xl-3 col-lg-4 col-md-6">

                            <div class="card h-100 shadow-sm border-0">

                                {{-- IMAGE --}}
                                @if ($blog->featured_image && Storage::disk('public')->exists('blog/' . $blog->featured_image))
                                    <img src="{{ asset('storage/blog/' . $blog->featured_image) }}" class="card-img-top"
                                        style="height:200px; object-fit:cover;">
                                @else
                                    <img src="{{ asset('images/default.jpg') }}" class="card-img-top"
                                        style="height:200px; object-fit:cover;">
                                @endif

                                {{-- BODY --}}
                                <div class="card-body">
                                    <h5 class="fw-semibold mb-2">
                                        {{ Str::limit($blog->post_title, 50) }}
                                    </h5>

                                    <p class="text-muted small mb-2">
                                        <i class="fa-regular fa-calendar me-1"></i>
                                        {{ $blog->created_at->format('d M Y') }}
                                    </p>

                                    <p class="small text-secondary">
                                        {{ Str::words(strip_tags($blog->blog_post), 18, '...') }}
                                    </p>
                                </div>

                                {{-- FOOTER --}}
                                <div
                                    class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">

                                    <a href="{{ route('blog.edit', $blog->id) }}"
                                        class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('blog.destroy', $blog->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this blog post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center py-4">
                                <i class="fas fa-info-circle me-1"></i>
                                No blog posts found.
                            </div>
                        </div>
                    @endforelse

                </div>

            </div>
        </div>
    </div>
@endsection
