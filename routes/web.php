<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Relationship\PoymorphicController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('O2O',[PoymorphicController::class,'O2O']);
Route::get('latestImage',[PoymorphicController::class,'latestImage']);
Route::get('PostImages',[PoymorphicController::class,'PostImages']);
Route::get('manyImages',[PoymorphicController::class,'manyImages']);
Route::get('imageLatest',[PoymorphicController::class,'imageLatest']);
Route::get('userProfile',[PoymorphicController::class,'userProfile']);
Route::get('createUserProfile',[PoymorphicController::class,'createUserProfile']);
Route::get('profilePosts',[PoymorphicController::class,'profilePosts']);
Route::get('latestPosts',[PoymorphicController::class,'latestPosts']);
Route::get('userPosts',[PoymorphicController::class,'userPosts']);
Route::get('craeteTagsforPost',[PoymorphicController::class,'craeteTagsforPost']);
Route::get('getTags',[PoymorphicController::class,'getTags']);
Route::get('getDataFromPivot',[PoymorphicController::class,'getDataFromPivot']);
Route::get('getProfileUser',[PoymorphicController::class,'getProfileUser']);
Route::get('getProfileUserFilter',[PoymorphicController::class,'getProfileUserFilter']);
Route::get('hasOneThroughPosts',[PoymorphicController::class,'hasOneThroughPosts']);
Route::get('m2m',[PoymorphicController::class,'m2m']);
###############################QUEUE#####################################
Route::get('processQueue',[JobController::class,'processQueue']);
################################EVENT###############################
Route::get('useEvent',[EventController::class,'useEvent']);
