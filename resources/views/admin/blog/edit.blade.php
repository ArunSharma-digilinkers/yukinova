@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="container-fluid py-4">

            {{-- PAGE HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Edit Blog Post</h3>
                <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary btn-sm">
                    ← Back to Blogs
                </a>
            </div>

            <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    {{-- LEFT : CONTENT --}}
                    <div class="col-lg-8">

                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Post Title</label>
                                    <input type="text" class="form-control" name="post_title"
                                        value="{{ $blog->post_title }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Blog Content</label>
                                    <textarea class="form-control ckeditor" name="blog_post" rows="8">{!! $blog->blog_post !!}</textarea>
                                </div>

                            </div>
                        </div>

                    </div>

                    {{-- RIGHT : META --}}
                    <div class="col-lg-4">

                        {{-- FEATURED IMAGE --}}
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">

                                <label class="form-label fw-semibold">Featured Image</label>

                                <div class="mb-3 text-center">
                                    <img src="{{ asset('storage/blog/' . $blog->featured_image) }}"
                                        class="img-fluid rounded border" style="max-height:180px">
                                </div>

                                <input type="file" class="form-control" name="featured_image">
                            </div>
                        </div>

                        {{-- SEO & META --}}
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">

                                <h6 class="fw-bold mb-3">SEO & Meta</h6>

                                <div class="mb-2">
                                    <label class="form-label">SEO Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ $blog->title }}">
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description"
                                        value="{{ $blog->description }}">
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Tags</label>
                                    <input type="text" class="form-control" name="tags" value="{{ $blog->tags }}">
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Category</label>
                                    <input type="text" class="form-control" name="category"
                                        value="{{ $blog->category }}">
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Author</label>
                                    <input type="text" class="form-control" name="author" value="{{ $blog->author }}">
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" value="{{ $blog->slug }}">
                                </div>

                            </div>
                        </div>

                        {{-- SAVE --}}
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-end">
                                <button type="submit" class="btn btn-warning w-100">
                                    Update Blog Post
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
