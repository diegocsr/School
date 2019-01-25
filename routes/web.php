<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('token', function () {
//     return Auth::user()->createToken('test');
// });
// Auth::routes();

/**
 * Frontend route
 * All route for frontend system
 */
Route::get('/', function () { return view('frontend.homepage.index'); })->name('homepage');
Route::group(['namespace' => 'Frontend'], function() {
  Route::get('informasi-guru', 'FrontendController@showTeacher')->name('index-teacher');
  Route::get('informasi-sekolah', 'FrontendController@schoolProfile')->name('school.profile');
  Route::get('informasi-siswa', 'FrontendController@showStudent')->name('index-student');
  Route::get('prestasi', 'FrontendController@showAchievement')->name('index-achievement');
  Route::get('prestasi/{slug}/detail', 'FrontendController@showDetailAchievement')->name('detail-achievement');
  Route::get('berita-sekolah', 'FrontendController@showEvent')->name('index-event');
  Route::get('berita-sekolah/{slug}/detail', 'FrontendController@detailEvent')->name('detail-event');
  Route::get('daftar-siswa', 'FrontendController@showStudent')->name('index-student');
  Route::get('daftar-album', 'FrontendController@showAlbum')->name('index-album');
  Route::get('detail-album/{id}/detail', 'FrontendController@detailAlbum')->name('detail-album');
});

/**
 * Backend route
 * All route for backend system
 */

//  Auth admin route
Route::group(['namespace' => 'Auth'], function() {
  Route::get('/admin-sistem/login', 'LoginController@showLoginForm')->name('login');
  Route::post('/admin-sistem/login', 'LoginController@login');
  Route::post('/logout', 'LoginController@logout')->name('logout');
  Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
  Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
  Route::post('/password/reset', 'ResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
  Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'RegisterController@register');
});

// Dashboard admin route 
Route::group(['namespace' => 'Backend'], function() {
  Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
  Route::get('/profil-sekolah', 'DashboardController@profile')->name('profile');
  Route::get('/daftar-guru', 'DashboardController@teacher')->name('teacher');
  Route::get('/program-sekolah', 'DashboardController@program')->name('program');
  Route::get('/daftar-siswa', 'DashboardController@student')->name('student');
  Route::get('/event-sekolah', 'DashboardController@event')->name('event');
  Route::get('/tambah-event', 'DashboardController@addEvent')->name('add.event');
  Route::get('/ubah-event/{slug}', 'DashboardController@updateEvent')->name('update.event');
  Route::get('/event/{slug}/detail', 'DashboardController@showEvent')->name('show.event');
  Route::get('/kategori-event', 'DashboardController@category')->name('category');
  Route::get('/pengaturan-akun', 'DashboardController@account')->name('account');
  Route::get('/daftar-prestasi', 'DashboardController@achievement')->name('achievement');
  Route::get('/tambah-prestasi', 'DashboardController@addAchievement')->name('add.achievement');
  Route::get('/ubah-prestasi/{slug}', 'DashboardController@updateAchievement')->name('update.achievement');
  Route::get('/album', 'DashboardController@albums')->name('albums');
  Route::get('/galeri/{id}/detail', 'DashboardController@detailGallery')->name('detail.gallery');
});