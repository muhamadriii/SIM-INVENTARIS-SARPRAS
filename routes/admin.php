<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MerchantController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\MemberAddressController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\TrackingOrderController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [HomeController::class, 'index'])->name('dashboard');
        //timpa route update karena upload image formdata harus pake post biar inputannya masuk ke controller
        Route::post('roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::resource('roles', RoleController::class);

        Route::post('permissions/{permission}', [PermissionController::class, 'update'])->name('admin.permissions.update');
        Route::resource('permissions', PermissionController::class);

        Route::get('member/diagram/{member_id}', [MemberController::class, 'diagram'])->name('member.diagram');
        Route::get('member/level/{member_id}', [MemberController::class, 'level'])->name('member.level');
        Route::resource('member', MemberController::class);

        Route::get('member/member-address/{member_id}', [MemberAddressController::class, 'index'])->name('member.member-address');
        Route::get('member/member-address/show/{id}', [MemberAddressController::class, 'show'])->name('member.member-address.show');
        Route::post('member/member-address/{member_id}/store', [MemberAddressController::class, 'store'])->name('member.member-address.store');
        Route::put('member/member-address/update/{id}', [MemberAddressController::class, 'update'])->name('member.member-address.update');
        Route::delete('member/member-address/destroy/{id}', [MemberAddressController::class, 'destroy'])->name('member.member-address.destroy');



        Route::post('menus/{menu}', [MenuController::class, 'update'])->name('admin.menus.update');
        Route::resource('menus', MenuController::class);

        Route::post('users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::resource('users', UserController::class);

        Route::post('levels/{level}', [LevelController::class, 'update'])->name('admin.levels.update');
        Route::resource('levels', LevelController::class);

        Route::resource('merchants', MerchantController::class);
        Route::post('products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::get('products/product-images/{id}', [ProductController::class, 'productImages'])->name('admin.products.product-images');

        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        // Route::resource('orders', OrderController::class);
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('orders/store', [OrderController::class, 'store'])->name('orders.store');
        Route::post('orders/update/{id}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('orders/destroy/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('orders/get-address', [OrderController::class, 'getAddress'])->name('orders.get-address');
        Route::get('orders/show/{order_id}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/edit/{order_id}', [OrderController::class, 'edit'])->name('orders.edit');
        Route::get('orders/update-status/{order_id}', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('orders/edit-resi/{order_id}', [OrderController::class, 'showResi'])->name('orders.show-resi');
        Route::put('orders/edit-resi/{order_id}', [OrderController::class, 'addResi'])->name('orders.edit-resi');



        Route::post('gallery/{id}', [GalleryController::class, 'update'])->name('admin.gallery.update');
        Route::resource('gallery', GalleryController::class);

        Route::get('orders/detail/list-order', [TrackingOrderController::class, 'listOrder'])->name('order-detail.list-order');
        Route::get('orders/detail/unpaid', [TrackingOrderController::class, 'unpaid'])->name('order-detail.unpaid');
        Route::get('orders/detail/waiting-for-approval', [TrackingOrderController::class, 'waitingForApproval'])->name('order-detail.waiting-for-approval');
        Route::get('orders/detail/paid', [TrackingOrderController::class, 'paid'])->name('order-detail.paid');
        Route::get('orders/detail/shipping', [TrackingOrderController::class, 'shipping'])->name('order-detail.shipping');
        Route::get('orders/detail/finish', [TrackingOrderController::class, 'finish'])->name('order-detail.finish');

        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('contact-us', ContactUsController::class);
        Route::resource('unit', UnitController::class);

        Route::get('payment/generate', [PaymentController::class, 'paymentGenerate'])->name('payment-generate');
        Route::get('payment/update-status/{payment_id}', [PaymentController::class, 'updateStatus'])->name('payment.update-status');
        Route::get('payment', [PaymentController::class, 'index'])->name('payment.index');
        Route::get('payment/show/{payment_id}', [PaymentController::class, 'show'])->name('payment.show');
        Route::get('payment/pdf-order/{id}', [PaymentController::class, 'pdf'])->name('payment-pdf');

        Route::resource('fee', FeeController::class);
        Route::resource('invoice', InvoiceController::class);

    });
});
