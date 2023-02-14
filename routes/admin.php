<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\MenuController;;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\ParentItemController;
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

        Route::post('menus/{id}', [MenuController::class, 'update'])->name('admin.menus.update');
        Route::resource('menus', MenuController::class);

        Route::post('users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::resource('users', UserController::class);
        
        Route::resource('categories', CategoryController::class);
        
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
        
        Route::resource('unit', UnitController::class);
        
        Route::post('items/{id}', [ParentItemController::class, 'update'])->name('admin.items.update');
        Route::resource('items', ParentItemController::class, ['except'=>['update']]);
        Route::post('generate-items/{id}', [ParentItemController::class, 'generateQrcode'])->name('generate-items.create');
        Route::get('show-items/{id}', [ParentItemController::class, 'ShowItem'])->name('children-items.show');
        Route::get('sku-items/{id}', [ParentItemController::class, 'Item'])->name('sku-items.show');
        
        Route::resource('requests', RequestController::class);
        Route::resource('loans', LoanController::class);

    });
});
