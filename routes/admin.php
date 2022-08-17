<?php


use Illuminate\Support\Facades\Route;


Route::prefix('ad')->group(function () {

    // if user hit /ad only in url it will redirect to admin dashboard home
    Route::redirect('/', '/ad/home');

    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'loginPost'])->name('admin.login.post');


    Route::middleware('CheckAuthAdmin')->group(function () {

        Route::get('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

        Route::get('/home', function () {
            return \Inertia\Inertia::render('Dashboard/Admin/Home');
        })->name('admin.home');


        /**
         * Admins Module
         */
        Route::resource('admins', \App\Http\Controllers\Admin\AdminsController::class);
        /**
         * Roles Module
         */
        Route::resource('roles', \App\Http\Controllers\Admin\RolesController::class);
        /**
         * Categories Module
         */
        Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class);
        Route::post('categories/toggle-active-state/{category}', [
            \App\Http\Controllers\Admin\CategoriesController::class, 'toggleActiveState'
        ])->name('categories.toggle-active-state');
        Route::get('update-select-levels', [
            \App\Http\Controllers\Admin\CategoriesController::class, 'updateSelectLevels'
        ])->name('categories.update-select-levels');
        /**
         * products Module
         */
        Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class);


    });
});
