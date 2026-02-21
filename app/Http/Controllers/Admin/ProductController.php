<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $products = Product::with(['category'])->latest()->get();
        return view('admin.product.index', compact('products')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $products = Product::all(); // all products to select add-ons from

    return view('admin.product.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|unique:products,name',
            'price'       => 'required|numeric',
            'sale_price'  => 'nullable|numeric',
            'quantity'    => 'required|integer',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'addons'      => 'nullable|array',
            'addons.*'    => 'exists:products,id',
        ]);

        /* ---------- MAIN IMAGE ---------- */
        $mainImage = null;
        if ($request->hasFile('image')) {
            $mainImage = time() . '.' . $request->image->extension();
            $request->image->storeAs('products', $mainImage, 'public');
        }

        /* ---------- GALLERY IMAGES ---------- */
        $gallery = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $name = uniqid() . '.' . $img->extension();
                $img->storeAs('products/gallery', $name, 'public');
                $gallery[] = $name;
            }
        }

        /* ---------- CREATE PRODUCT ---------- */
        $product = Product::create([
            'category_id'          => $request->category_id,
            'name'                 => $request->name,
            'slug'                 => Str::slug($request->name),
            'price'                => $request->price,
            'sale_price'           => $request->sale_price,
            'gst_percentage'       => $request->gst_percentage ?? 0,
            'gst_type'             => $request->gst_type ?? 'inclusive',
            'shipping_type'        => $request->shipping_type ?? 'free',
            'shipping_rate'        => $request->shipping_rate ?? 0,
            'short_description'    => $request->short_description,
            'technical_features'   => $request->technical_features,
            'warranty'             => $request->warranty,
            'youtube_url'             => $request->youtube_url,
            'quantity'             => $request->quantity,
            'description'          => $request->description,
            'status'               => $request->status ?? 1,
            'is_new_arrival' => $request->has('is_new_arrival') ? 1 : 0,
            'image'                => $mainImage,
            'images'               => $gallery,
            'hsn_code'               => $request->hsn_code,
        ]);

        return redirect()
            ->route('product.index')
            ->with('success', 'Product created successfully');
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
    public function edit(Product $product)
    {
        $categories = Category::all();
        $products   = Product::where('id', '!=', $product->id)->get();

        return view('admin.product.edit', compact('product', 'categories', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
         $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name'        => 'required|unique:products,name,' . $product->id,
        'price'       => 'required|numeric',
        'sale_price'  => 'nullable|numeric',
        'quantity'    => 'required|integer',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp',
        'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp',
    ]);

    $data = [
        'category_id'        => $request->category_id,
        'name'               => $request->name,
        'slug'               => Str::slug($request->name),
        'price'              => $request->price,
        'sale_price'         => $request->sale_price,
        'gst_percentage'     => $request->gst_percentage ?? 0,
        'gst_type'           => $request->gst_type ?? 'inclusive',
        'shipping_type'      => $request->shipping_type ?? 'free',
        'shipping_rate'      => $request->shipping_rate ?? 0,
        'short_description'  => $request->short_description,
        'technical_features' => $request->technical_features,
        'warranty'           => $request->warranty,
        'quantity'           => $request->quantity,
        'description'        => $request->description,
        'status'             => $request->status,
         'is_new_arrival' => $request->has('is_new_arrival') ? 1 : 0,
        'hsn_code'             => $request->hsn_code,
    ];

    /* ===============================
       REPLACE MAIN IMAGE
    =============================== */
    if ($request->hasFile('image')) {

        if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        $mainImage = time() . '.' . $request->image->extension();
        $request->image->storeAs('products', $mainImage, 'public');

        $data['image'] = $mainImage;
    }

    /* ===============================
       HANDLE GALLERY IMAGES
    =============================== */

    // Get existing images
    $gallery = $product->images ?? [];

    // 1️⃣ Remove selected images
    if ($request->filled('removed_images')) {

        $removedImages = explode(',', $request->removed_images);

        foreach ($removedImages as $img) {

            $img = trim($img);

            // Delete from storage
            Storage::disk('public')->delete('products/gallery/' . $img);

            // Remove from array safely
            $gallery = array_filter($gallery, function ($existing) use ($img) {
                return $existing !== $img;
            });
        }
    }

    // 2️⃣ Add newly uploaded images
    if ($request->hasFile('images')) {

        foreach ($request->file('images') as $img) {

            $name = uniqid() . '.' . $img->extension();
            $img->storeAs('products/gallery', $name, 'public');

            $gallery[] = $name;
        }
    }

    // Reindex array and store
    $data['images'] = array_values($gallery);

    /* ===============================
       UPDATE PRODUCT
    =============================== */
    $product->update($data);

    /* ===============================
       SYNC ADD-ONS
    =============================== */
  

    return redirect()
        ->route('product.index')
        ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
       if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        if ($product->images) {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete('products/gallery/' . $img);
            }
        }

        $product->addons()->detach();
        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('success', 'Product deleted successfully');
    }
}