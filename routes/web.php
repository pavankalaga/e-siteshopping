<?php

use App\Http\Controllers\AuthenticController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthenticController::class,'form'])->name('form');
Route::post('/login/post', [AuthenticController::class,'login'])->name('login.post');

Route::get('/register/form', [AuthenticController::class, 'registerForm'])->name('register.form');
Route::post('/register/post', [AuthenticController::class,'registerStore'])->name('register.post');

Route::post('logout', [AuthenticController::class, 'logout'])->name('logout');

Route::middleware('user')->group(function(){
Route::resource('/product',ProductController::class);

Route::get('/card/view', [CartController::class, 'card_view'])->name('card.views');


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
Route::get('/checkout/order', [CartController::class, 'place_order'])->name('checkout.order');
Route::post('/checkout/post', [CartController::class, 'process'])->name('checkout.process');
});