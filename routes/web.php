<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ShippingZoneController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\OrderController;


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
Route::get('hybrid-inverter', [PagesController::class, 'inverterhybrid']);   
Route::get('inverter-battery', [PagesController::class, 'inverterbatt']);   
Route::get('/product/{id}', [PagesController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [PagesController::class, 'category'])->name('category.products');

Route::get('privacy-policy', [PagesController::class, 'privacypolicy']); 
Route::get('return-policy', [PagesController::class, 'returnpolicy']); 
Route::get('terms-and-conditions', [PagesController::class, 'terms']); 

// For admin
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    Route::resource('category', CategoryController::class); 
    Route::resource('product', ProductController::class);
    Route::resource('coupons', CouponController::class)->except('show');
    Route::resource('shipping-zones', ShippingZoneController::class)->except('show');
    Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});


/* USER ROUTES */
Route::prefix('user')->middleware(['auth', 'role:user'])->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders/{order}', [UserDashboardController::class, 'showOrder'])->name('orders.show');
    Route::resource('addresses', AddressController::class)->except(['show']);

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
