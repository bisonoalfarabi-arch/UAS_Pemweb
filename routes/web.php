<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\RentalAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{equipment}', [CatalogController::class, 'show'])->name('catalog.show');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| User (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    

    Route::get('/my-rentals', [RentalController::class, 'myRentals'])->name('rentals.my');
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::patch('/rentals/{rental}/cancel', [RentalController::class, 'cancel'])->name('rentals.cancel');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::resource('equipment', EquipmentController::class)->except('show');
    Route::resource('users', UserController::class)->except('create', 'store');

    Route::get('/rentals', [RentalAdminController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/{rental}', [RentalAdminController::class, 'show'])->name('rentals.show');
    Route::put('/rentals/{rental}/approve', [RentalAdminController::class, 'approve'])->name('rentals.approve');
    Route::put('/rentals/{rental}/reject', [RentalAdminController::class, 'reject'])->name('rentals.reject');
    Route::put('/rentals/{rental}/complete', [RentalAdminController::class, 'complete'])->name('rentals.complete');

    Route::get('/reports', [AdminDashboard::class, 'reports'])->name('reports');
    Route::get('/reports/rentals', [AdminDashboard::class, 'rentalReport'])->name('reports.rentals');
    Route::get('/reports/revenue', [AdminDashboard::class, 'revenueReport'])->name('reports.revenue');

    Route::delete('/rentals/{rental}', [RentalAdminController::class, 'destroy'])->name('rentals.destroy');

});
