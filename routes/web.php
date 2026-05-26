<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\GoogleAdsApi\Controllers\GoogleAdsController;
use App\Http\Controllers\Blog\BlogController;

Route::view('', 'admin.login');
Route::view('admin-login', 'admin.login');
Route::view('admin-signup', 'admin.signup');
Route::post('admin-login', [AdminController::class, 'login']);
Route::post('admin-signup', [AdminController::class, 'signup']);
Route::get('admin-logout', [AdminController::class, 'logout']);
Route::post('/forget-password', [AdminController::class, 'forgetPassword']);
Route::post('/verify-otp', [AdminController::class, 'verifyOtp']);

Route::get('dashboard', [AdminController::class, 'dashboard']);
Route::post('/get-blog-details', [AdminController::class, 'getBlogDetails']);
Route::post('/set-category-details', [AdminController::class, 'setCategoryDetails']);
Route::post('/set-blog-details', [AdminController::class, 'setBlogDetails']);
Route::post('/get-category-details', [AdminController::class, 'getCategoryDetails']);
Route::post('/get-tag-details',[AdminController::class, 'getTagDetails']);
Route::post('/set-tag-details', [AdminController::class, 'setTagDetails']);

Route::post('/delete-blog', [AdminController::class, 'deleteBlog']);

Route::post('/get-blog-by-id', [AdminController::class, 'getBlogById']);
Route::post('/update-blog-details', [AdminController::class, 'updateBlogDetails']);

Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{slug}', [BlogController::class, 'details']);