<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\Relationship\PoymorphicController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Pusher\Pusher;

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

#############################################################
//Route::resource('posts', 'PostsController');
Route::get('allPosts',[PostsController::class,'index']);
Route::get('getFollwers',[FollowerController::class,'getFollwers']);
Route::get('getAllFollower/{id}',[FollowerController::class,'getAllFollower']);
Route::get('users', [FollowerController::class,'index1'])->name('users');
/*
 * https://www.sitepoint.com/add-real-time-notifications-laravel-pusher/
 */

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('users', [FollowerController::class,'index1'])->name('users');
    Route::post('users/{user}/follow', [FollowerController::class,'follow'])->name('follow');
    Route::delete('users/{user}/unfollow', [FollowerController::class,'unfollow'])->name('unfollow');
    Route::get('notifications', [FollowerController::class,'showingNotifications']);
});

#################### GATE AND POLICIES ###################

Route::get('candelete/{post}', [PostsController::class,'delete'])->middleware('can:delete,post');


Route::get('/testGate', function () {
    if (Gate::allows('isAdmin')) {

        dd('Admin allowed');

    } else {

        dd('You are not Admin');

    }
})->middleware('can:isAdmin');
