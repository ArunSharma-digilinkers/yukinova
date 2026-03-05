  @extends('layouts.main')
  @section('title', $blogs->title)
  @section('description', $blogs->description)

  @section('content')

  <div class="main-wrapper">
      <div class="page-banner-blog">
          <div class="container">
              <div class="row">
                  <div class="col-lg-12">
                      <h2>{{$blogs->post_title}}</h2>
                  </div>
              </div>
          </div>
      </div>
      <div class="details-blog-wrapper section-entry">
          <div class="container">
              <div class="row">
                  <div class="col-md-12">

                      <div class="blog-img-wrap">
                          <img src="{{ asset('storage/blog/' . $blogs->featured_image) }}" alt="Uploaded Image"
                              class="img-fluid">
                      </div>
                      <div class="blog-description-wrap mt-3">
                          <h5><i class="fa-regular fa-calendar"></i> {{$blogs->created_at->format('d-m-Y')}}</h5>
                          <p>{!! $blogs->blog_post !!}</p>
                      </div>

                  </div>
              </div>
          </div>
      </div>
  </div>
  @endsection