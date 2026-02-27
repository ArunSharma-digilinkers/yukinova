<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        $products = Product::where('status', 1)
            ->where('is_new_arrival', 1)
            ->latest()
            ->limit(8)
            ->get();

        $categories = Category::all();

        return view('pages.index', compact('products', 'categories'));

    }

    public function about() {
        return view('pages.about-us');
    }

       public function contact() {
        return view('pages.contact-us');
    }

     public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->orderBy('id', 'asc')
            ->get();

        $categories = Category::all();

        return view('products.category', compact('products', 'categories', 'category'));
    }

      public function show($slug)
    {
        $product = Product::where('slug', $slug)
                        ->where('status', 1)
                        ->firstOrFail();

        return view('products.show', compact('product'));
    }

     public function twowheeler()
    {
        // Get category
        $category = Category::where('name', 'Two Wheeler Battery')->firstOrFail();

        // Get products in ASC order
        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->get();

        // All categories (for menu/sidebar)
        $categories = Category::all();

        return view('products.two-wheeler-battery', compact('products','categories','category'));
    }

     public function threewheeler()
    {
        // Get category
        $category = Category::where('name', 'Three Wheeler Battery')->firstOrFail();

        // Get products in ASC order
        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->get();

        // All categories (for menu/sidebar)
        $categories = Category::all();

        return view('products.three-wheeler-battery', compact('products','categories','category'));
    }

         public function tractionbattery()
    {
        // Get category
        $category = Category::where('name', 'Traction Battery')->firstOrFail();

        // Get products in ASC order
        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->get();

        // All categories (for menu/sidebar)
        $categories = Category::all();

        return view('products.traction-battery', compact('products','categories','category'));
    }

             public function portablepower()
    {
        // Get category
        $category = Category::where('name', 'Portable Power Solution')->firstOrFail();

        // Get products in ASC order
        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->get();

        // All categories (for menu/sidebar)
        $categories = Category::all();

        return view('products.portable-power-solution', compact('products','categories','category'));
    }

    public function solarbatt()
    {
        // Get category
        $category = Category::where('name', 'Solar Battery')->firstOrFail();

        // Get products in ASC order
        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->get();

        // All categories (for menu/sidebar)
        $categories = Category::all();

        return view('products.solar-battery', compact('products','categories','category'));
    }

       public function cyclebatt()
    {
        // Get category
        $category = Category::where('name', 'Cycle Battery')->firstOrFail();

        // Get products in ASC order
        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->get();

        // All categories (for menu/sidebar)
        $categories = Category::all();

        return view('products.cycle-battery', compact('products','categories','category'));
    }

          public function energysolution()
    {
        // Get category
        $category = Category::where('name', 'Energy Solution System')->firstOrFail();

        // Get products in ASC order
        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->get();

        // All categories (for menu/sidebar)
        $categories = Category::all();

        return view('products.energy-solution-system', compact('products','categories','category'));
    }

             public function commercialindustrial()
    {
        // Get category
        $category = Category::where('name', 'Energy Solution System')->firstOrFail();

        // Get products in ASC order
        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->get();

        // All categories (for menu/sidebar)
        $categories = Category::all();

        return view('products.ess-commercial-industrial', compact('products','categories','category'));
    }

    public function inverterhybrid()
    {
        // Get category
        $category = Category::where('name', 'Hybrid Inverter')->firstOrFail();

        // Get products in ASC order
        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->get();

        // All categories (for menu/sidebar)
        $categories = Category::all();

        return view('products.hybrid-inverter', compact('products','categories','category'));
    }

        public function inverterbatt()
    {
        // Get category
        $category = Category::where('name', 'Hybrid Inverter')->firstOrFail();

        // Get products in ASC order
        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->get();

        // All categories (for menu/sidebar)
        $categories = Category::all();

        return view('products.inverter-battery', compact('products','categories','category'));
    }
    
    public function privacypolicy() {
        return view('pages.privacy-policy');
    }

      public function returnpolicy() {
        return view('pages.return-policy');
    }

      public function terms() {
        return view('pages.terms-and-conditions');
    }
}
