<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $blogs = Blog::latest()->get();
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
        'post_title' => 'required|string|max:255',
        'blog_post'  => 'required',
        'featured_image' => 'required|image',
    ]);

    // ✅ Generate slug from post title
    $slug = Str::slug($request->post_title);

    // ✅ Ensure slug is unique
    $originalSlug = $slug;
    $count = 1;

    while (Blog::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $count;
        $count++;
    }

    $filename = null;

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . rand(0, 9999) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('blog', $filename, 'public');
        }

    Blog::create([
        'post_title'     => $request->post_title,
        'blog_post'      => $request->blog_post,
        'title'          => $request->title,
        'description'    => $request->description,
        'tags'           => $request->tags,
        'category'       => $request->category,
        'slug'           => $slug,
        'author'         => $request->author,   
        'featured_image' => $filename,
    ]);

    return redirect()
        ->route('blog.index')
        ->with('success', 'Blog post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'post_title'     => 'required|string|max:255',
            'blog_post'      => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        $filename = $blog->featured_image;

        if ($request->hasFile('featured_image')) {
            // delete old file if exists
            if ($filename && Storage::disk('public')->exists('blog/' . $filename)) {
                Storage::disk('public')->delete('blog/' . $filename);
            }

            $file = $request->file('featured_image');
            $filename = time() . rand(0, 9999) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('blog', $filename, 'public');
        }

        $blog->update([
            'featured_image' => $filename,
            'post_title'     => $request->post_title,
            'blog_post'      => $request->blog_post,
            'title'          => $request->title,
            'description'    => $request->description,
            'tags'           => $request->tags,
            'category'       => $request->category,
            'slug'           => $request->slug,
            'author'         => $request->author,
        ]);

        return redirect('/admin/blog/')->with('message', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
          if ($blog->featured_image && Storage::disk('public')->exists('blog/' . $blog->featured_image)) {
            Storage::disk('public')->delete('blog/' . $blog->featured_image);
        }

        $blog->delete();

        return redirect('/admin/blog/')->with('message', 'Post deleted successfully');
    }

  }

