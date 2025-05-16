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
Route::middleware(['auth', 'verified'])->get('/menu-survey', [SurveyController::class, 'generalUserSurvey'])->name('menu-survey');
Route::middleware(['auth'])->get('/fill-survey/{id}', [SurveyController::class, 'generalSurveyFill'])->name('survey.fill');
Route::post('/submit-survey', [SurveyController::class, 'submitSurvey'])->middleware('auth');

/**Admin routes **/
Route::middleware('adminAuth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('adminDashboardShow');
});

// Route::get('survey/{id}', [SurveyController::class, 'show'])->name('survey.show');
Route::get('master-survey', [SurveyController::class, 'index'])->name('master-survey');
Route::get('/survey/{id}', [SurveyController::class, 'getSurveyWithQuestions']);
Route::post('/survey/{surveyId}/pertanyaan', [SurveyController::class, 'addQuestion']);
Route::get('/survey/create', [SurveyController::class, 'create'])->name('survey.create');
Route::post('/survey/store', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/survey/{id}/edit', [SurveyController::class, 'edit'])->name('survey.edit');
Route::put('/survey/{id}/update', [SurveyController::class, 'update'])->name('survey.update');
Route::delete('survey/{id}/hapus-pertanyaan', [SurveyController::class, 'destroy'])->name('survey.hapus-pertanyaan');


Route::get('/admin/survey/get-data', [SurveyController::class, 'getData'])->name('admin.survey.getData');
Route::get('/admin/survey/get-data-jawaban', [SurveyController::class, 'getDataJawaban'])->name('admin.survey.getDataJawaban');
Route::get('/admin/survey/get-data-survey', [SurveyController::class, 'getDataSurvey'])->name('admin.survey.getDataSurvey');

Route::get('/master-pelatihan', [PelatihanController::class, 'index'])->name('master-pelatihan');

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
