<?php
use App\Http\Controllers\WebDevelopmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/web-development', [WebDevelopmentController::class, 'index'])->name('web-development.index');

Route::get('/contact-us', function (){
    return view('contact');
});
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/about-mssl', function (){
    return view('about');
});
Route::get('/career', function (){
    return view('career');
});

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.show');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
