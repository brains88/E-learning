<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\frontend\HomeController::class, 'index'])->name('home');
Route::get('/courses', [App\Http\Controllers\frontend\CoursesController::class, 'index'])->name('courses.index'); // Display courses list // Show course details in a modal (Optional)
Route::post('/enroll/{courseId}', [App\Http\Controllers\frontend\CoursesController::class, 'enroll'])->name('enroll');
Route::get('/my-courses/{course}', [App\Http\Controllers\user\CoursesController::class, 'show'])->name('course.details');
Route::post('/chatbot', [App\Http\Controllers\frontend\ChatbotController::class, 'chat'])->name('chatbot');
//Auth Routes
Route::get('/login', [App\Http\Controllers\auth\LoginController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\auth\LoginController::class, 'login'])->name('login');
Route::get('/register', [App\Http\Controllers\auth\RegisterController::class, 'index'])->name('register');
Route::post('/register', [App\Http\Controllers\auth\RegisterController::class, 'store'])->name('register.store');
Route::get('/courses', [App\Http\Controllers\frontend\CoursesController::class, 'index'])->name('courses');
Route::get('/logout', [App\Http\Controllers\auth\LoginController::class, 'logout'])->name('logout');

//User Routes
Route::middleware(['auth', 'user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\user\DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/my-courses', [App\Http\Controllers\user\CoursesController::class, 'index'])->name('user.my-courses');
    Route::get('/quizzes', [App\Http\Controllers\user\QuizzesController::class, 'index'])->name('user.quizzes');
    Route::get('/progress', [App\Http\Controllers\user\ProgressController::class, 'index'])->name('user.progress');
    Route::get('/messages', [App\Http\Controllers\user\MessageController::class, 'index'])->name('user.messages');
    Route::get('/profile', [App\Http\Controllers\user\ProfileController::class, 'index'])->name('user.profile');
    Route::post('/profile/update', [App\Http\Controllers\user\ProfileController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/courses/{course}/learn', [App\Http\Controllers\user\CourseController::class, 'learn'])->name('courses.learn');
    Route::post('/quizzes/submit/{courseId}', [App\Http\Controllers\user\QuizzesController::class, 'submitAnswer'])->name('user.quizzes.submit');
    Route::get('/messages', [App\Http\Controllers\user\MessageController::class, 'index'])->name('user.messages');
    Route::post('/messages', [App\Http\Controllers\user\MessageController::class, 'store'])->name('user.messages.store');
});

//Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/students', [App\Http\Controllers\admin\UserController::class, 'index'])->name('admin.students');
    Route::delete('/students/{id}', [App\Http\Controllers\admin\UserController::class, 'destroy'])->name('admin.students.destroy');
    Route::get('/students/{id}', [App\Http\Controllers\admin\UserController::class, 'show'])->name('admin.students.show');
    Route::get('/tutorials', [App\Http\Controllers\admin\CoursesController::class, 'index'])->name('admin.tutorials'); // View all courses
    Route::get('/courses/create', [App\Http\Controllers\admin\CoursesController::class, 'create'])->name('admin.courses.create'); // Create a new course
   Route::post('/courses/store', [App\Http\Controllers\admin\CoursesController::class, 'store'])->name('admin.courses.store');
    Route::post('/courses/update/{course}', [App\Http\Controllers\admin\CoursesController::class, 'update'])->name('admin.courses.update');
    Route::delete('/courses/{course}', [App\Http\Controllers\admin\CoursesController::class, 'destroy'])->name('admin.courses.destroy'); // Delete a course
    Route::get('/quizzes', [App\Http\Controllers\admin\QuizzesController::class, 'index'])->name('admin.quizzes');
    Route::get('/progress', [App\Http\Controllers\admin\ProgressController::class, 'index'])->name('admin.progress');
    Route::get('/messages', [App\Http\Controllers\admin\MessageController::class, 'index'])->name('admin.messages');
    Route::get('/profile', [App\Http\Controllers\admin\ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/profile/update', [App\Http\Controllers\admin\ProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/courses/{course}/learn', [App\Http\Controllers\admin\CourseController::class, 'learn'])->name('courses.learn');
    Route::post('/quizzes/submit/{courseId}', [App\Http\Controllers\admin\QuizzesController::class, 'submitAnswer'])->name('admin.quizzes.submit');
    Route::get('/messages', [App\Http\Controllers\admin\MessageController::class, 'index'])->name('admin.messages');
    Route::post('/messages', [App\Http\Controllers\admin\MessageController::class, 'store'])->name('admin.messages.store');
    Route::post('/messages/reply/{id}', [App\Http\Controllers\admin\MessageController::class, 'reply'])->name('admin.messages.reply'); // For admin
});

Route::get('/{pathMatch}', function() {
    return view('frontend.home');
})->where('pathMatch',".*");