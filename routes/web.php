<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {

   return '<h1 style="text-align: center">Welcome To Algoriza <br> <a href="/ad">تسجيل دخول</a></h1> ';

});

require __DIR__ . '/admin.php';
require __DIR__ . '/system.php';

