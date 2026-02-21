<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;


// pages
Route::get('/', [PagesController::class, 'index']);
Route::get('about-us', [PagesController::class, 'about']);
Route::get('contact-us', [PagesController::class, 'contact']);
Route::get('two-wheeler-battery', [PagesController::class, 'twowheeler']);
Route::get('three-wheeler-battery', [PagesController::class, 'threewheeler']);
Route::get('traction-battery', [PagesController::class, 'tractionbattery']);    
Route::get('portable-power-solution', [PagesController::class, 'portablepower']);       
Route::get('solar-battery', [PagesController::class, 'solarbatt']);    
Route::get('cycle-battery', [PagesController::class, 'cyclebatt']);    
Route::get('energy-solution-system', [PagesController::class, 'energysolution']);    
Route::get('ess-commercial-industrial', [PagesController::class, 'commercialindustrial']);    
Route::get('/product/{id}', [PagesController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [PagesController::class, 'category'])->name('category.products');


// For admin
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    Route::resource('category', CategoryController::class); 
    Route::resource('product', ProductController::class);
    Route::resource('coupons', CouponController::class)->except('show');
});


// For Cart
Route::post('/cart/add/{slug}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{slug}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{slug}', [CartController::class, 'remove'])->name('cart.remove');


// Checkout (Guest allowed)
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout');

Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])
    ->name('checkout.place');

Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])
    ->name('checkout.applyCoupon');

Route::get('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])
    ->name('checkout.removeCoupon');

Route::get('/checkout/shipping-cost', [CheckoutController::class, 'getShippingCost'])
    ->name('checkout.shippingCost');

Route::post('/checkout/save-abandoned', [CheckoutController::class, 'saveAbandonedCheckout'])
    ->name('checkout.saveAbandoned');

Route::get('/checkout/address/{address}', [CheckoutController::class, 'getAddress'])
    ->middleware('auth')
    ->name('checkout.getAddress');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
