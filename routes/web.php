<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\OrdersController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ReportsController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\users\CartController;
use App\Http\Controllers\users\HomeController;
use App\Http\Controllers\users\PlacedOrderController;
use App\Http\Controllers\users\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'UsersLoginPage'])->name('users.login');

// USERS
Route::get('/login', [AuthController::class, 'UsersLoginPage'])->name('users.login');
Route::get('/register', [AuthController::class, 'RegisterPage'])->name('users.register');
Route::post('/register-submit', [AuthController::class, 'RegisterSubmit'])->name('users.register.submit');
Route::post('/login', [AuthController::class, 'LoginSubmit'])->name('users.login.submit');
Route::post('/logout', [AuthController::class, 'Logout'])->name('users.logout');


Route::get('/home', [HomeController::class, 'HomePage'])->name('home.page');

Route::get('/shop', [ShopController::class, 'ShopPage'])->name('product.page');
Route::post('/cart/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/my-cart', [CartController::class, 'showCart'])->name('cart.show');
Route::delete('/cart/{cartItemId}', [CartController::class, 'deleteFromCart'])->name('cart.delete');

Route::get('/place-order', [PlacedOrderController::class, 'showOrderForm'])->name('order.place');
Route::post('/place-order', [PlacedOrderController::class, 'placeOrder'])->name('order.place');

Route::get('/my-orders', [App\Http\Controllers\users\MyOrderController::class, 'index'])
    ->middleware('auth') // ensures only logged-in users can access
    ->name('my_orders.page');






// ADMIN
Route::get('/admin/admin_login', [AuthController::class, 'AdminLoginPage'])->name('admin.login');
// Admin login form submit (POST request)
Route::post('/admin/login', [AuthController::class, 'AdminLoginSubmit'])->name('admin.login.submit');
// Admin dashboard page (Requires authentication as an admin)
Route::get('/admin/dashboard', [DashboardController::class, 'DashboardPage'])->name('admin.dashboard');
// Admin logout (POST request)
Route::post('/admin/logout', [AuthController::class, 'AdminLogout'])->name('admin.logout');

Route::get('/admin/products', [ProductController::class, 'AdminProductPage'])->name('admin.product');
Route::post('/admin/products/add', [ProductController::class, 'AddProduct'])->name('admin.addproduct');

Route::get('/admin/orders', [OrdersController::class, 'index'])->name('admin.orders');
Route::get('/admin/orders/view/{order_code}', [OrdersController::class, 'viewOrderDetails'])->name('admin.orders.view');
Route::put('/admin/orders/{order_code}', [OrdersController::class, 'updateOrderDetails'])->name('admin.orders.update');


Route::get('/admin/reports', [ReportsController::class, 'ReportsPage'])->name('admin.reports');
Route::prefix('admin/reports')->group(function () {
    Route::get('/daily', [ReportsController::class, 'printDailyReport'])->name('admin.reports.daily');
    Route::get('/weekly', [ReportsController::class, 'printWeeklyReport'])->name('admin.reports.weekly');
    Route::get('/monthly', [ReportsController::class, 'printMonthlyReport'])->name('admin.reports.monthly');
});
