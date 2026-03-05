@extends('layouts.admin')

@section('content')
    <div class="main-wrapper py-4">
        <div class="container-fluid">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="fw-bold mb-0">Create Blog Post</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">

                            {{-- Post Title --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Post Title *</label>
                                <input type="text" class="form-control" name="post_title" placeholder="Enter post title"
                                    required>
                            </div>

                            {{-- Featured Image --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Featured Image *</label>
                                <input type="file" class="form-control" name="featured_image" required>
                            </div>

                            {{-- Blog Content --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Blog Content *</label>
                                  <div class="mb-3">
                                    <label class="form-label">Technical Features</label>
                                    <textarea name="blog_post" class="form-control ckeditor" rows="4"></textarea>
                                </div>
                               
                            </div>

                            {{-- SEO Title --}}
                            <div class="col-md-4">
                                <label class="form-label">SEO Title</label>
                                <input type="text" class="form-control" name="title" placeholder="SEO title">
                            </div>

                            {{-- SEO Description --}}
                            <div class="col-md-4">
                                <label class="form-label">SEO Description</label>
                                <input type="text" class="form-control" name="description" placeholder="SEO description">
                            </div>

                            {{-- Tags --}}
                            <div class="col-md-4">
                                <label class="form-label">Tags</label>
                                <input type="text" class="form-control" name="tags" placeholder="Tags">
                            </div>

                            {{-- Category --}}
                            <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" name="category" placeholder="Category">
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-4">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control" name="slug"
                                    placeholder="auto-generated-if-empty" readonly>
                            </div>

                            {{-- Author --}}
                            <div class="col-md-4">
                                <label class="form-label">Author</label>
                                <input type="text" class="form-control" name="author" placeholder="Author name">
                            </div>

                            {{-- Submit --}}
                            <div class="col-12 text-end mt-3">
                                <button type="submit" class="btn btn-submit px-4">
                                    Publish Blog
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
