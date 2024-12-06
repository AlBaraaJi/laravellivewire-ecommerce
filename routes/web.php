<?php

use App\Livewire\Admin\Products\ListProducts;
use App\Livewire\View\ViewPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Users\ListUsers;
use App\Livewire\Admin\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('index', ViewPage::class)->name('index');

Route::get('admin/dashboard', Dashboard::class)->name('admin.dashboard');
Route::get('admin/users', ListUsers::class)->name('admin.users');
Route::get('admin/products', ListProducts::class)->name('admin.products');
