<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminAuthController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Admin\PelatihanController;
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
/* 
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/**General user routes **/
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'generalUserDashboard'])->name('dashboard');

/**Admin routes **/
Route::middleware('adminAuth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('adminDashboardShow');
});
Route::get('/survey', [SurveyController::class, 'index'])->name('adminSurveyShow');
Route::get('/survey/create', [SurveyController::class, 'create'])->name('survey.create');
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/survey/{id}', [SurveyController::class, 'show'])->name('survey.show');
Route::get('/admin/survey/get-data', [SurveyController::class, 'getData'])->name('admin.survey.getData');
Route::get('/admin/survey/get-data-jawaban', [SurveyController::class, 'getDataJawaban'])->name('admin.survey.getDataJawaban');
Route::get('/admin/survey/{id}/edit', [SurveyController::class, 'edit'])->name('admin.survey.editData');
Route::get('/admin/survey/{id}/hapus', [SurveyController::class, 'hapus'])->name('admin.survey.hapusData');

Route::get('/pelatihan', [PelatihanController::class, 'index'])->name('adminPelatihanShow');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('adminLogin');
    Route::post('/loginSubmit', [AdminAuthController::class, 'loginSubmit'])->name('adminLoginSubmit');
    Route::get('/logout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');
});

/**Super Admin routes **/
Route::middleware('superAdminAuth')->prefix('superAdmin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'superAdminDashboard'])->name('superAdminDashboardShow');
});
Route::prefix('superAdmin')->group(function () {
    Route::get('/login', [SuperAdminAuthController::class, 'login'])->name('superAdminLogin');
    Route::post('/loginSubmit', [SuperAdminAuthController::class, 'loginSubmit'])->name('superAdminLoginSubmit');
    Route::get('/logout', [SuperAdminAuthController::class, 'superAdminLogout'])->name('superAdminLogout');
});
