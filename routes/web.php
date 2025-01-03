<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ResetController;


Route::get('/', function () {
    return redirect('home');
});


//FACOLTA
Route::post("/facolta", [DepartmentController::class, 'facolta']);
Route::post("/corso", [DepartmentController::class, 'corso']);
//LOGIN
Route::get('login', [AuthController::class, 'login'])->name('login');
//REGISTRAZIONE
Route::get('registration', [AuthController::class, 'check'])->name('registration');
//LOGOUT
Route::get("logout", [AuthController::class, 'logout'])->name('logout');
//RESET 
Route::get('forget-password', [ResetController::class, 'forget'])->name('forget');
Route::post('forget-password', [ResetController::class, 'forgetForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ResetController::class, 'Reset'])->name('reset.password');
Route::post('reset-password', [ResetController::class, 'ResetForm'])->name('reset.password.post');
//HOME
Route::get("/home", [HomeController::class, 'index'])->name('home');
Route::post('/home/contact', [HomeController::class, 'contact'])->name('contact');
//FETCH DATI
Route::post('login', [AuthController::class, 'checklogin']);
Route::post('login/photo', [AuthController::class, 'pick']);
Route::post('registration', [AuthController::class, 'register']);
Route::post("registration/Username", [AuthController::class, 'checkUsername']);
Route::post("registration/Email", [AuthController::class, 'checkEmail']);
Route::post("registration/photo", [AuthController::class, 'pick']);
Route::post("home/photo", [HomeController::class, 'pick']);


Route::group(['middleware' => ['auth']], function () {
    //POST
    Route::get('/posts', [PostController::class, 'check'])->name('posts');
    Route::post('/posts/retrieve', [PostController::class, 'retrieve']);
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/edit/{post}', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/update/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/delete/{post}', [PostController::class, 'delete'])->name('posts.delete');
    Route::post('/post/favorites/{post}', [PostController::class, 'toggleFavorite']);
    Route::get('/posts/filter-course/{q}', [PostController::class, 'filterCorso']);
    Route::get('/posts/search/{q}', [PostController::class, 'searchPost']);
    //CONVERSAZIONE
    Route::get('/chats/{username?}', [MessageController::class, 'index'])->name('chats');
    Route::post('/chats/getUser', [MessageController::class, 'getUser']);
    Route::post('/chats/{user}/messages', [MessageController::class, 'store']);
    Route::post('/chats/check/{user}', [MessageController::class, 'check']);
    Route::post('/chats/last', [MessageController::class, 'getLastChat']);
    Route::post('/chats/all', [MessageController::class, 'getAllChat']);
    //PROFILO
    Route::get('/profile', [ProfileController::class, 'check'])->name('profile');
    Route::post('/profile/retrieve', [ProfileController::class, 'retrieve']);
});
