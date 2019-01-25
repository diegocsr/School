<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * Api access for Frontend
 */
Route::group(['namespace' => 'Api\Frontend'], function () {
    // Api for homepage program
    Route::get('homepage-program', 'HomepageApi@getProgram')->name('api.frontend.program');
    Route::get('homepage-achievement', 'HomepageApi@getAchievement')->name('api.frontend.achievement');
    Route::get('homepage-intro', 'HomepageApi@getIntro');
    Route::get('homepage-event', 'HomepageApi@getEvents');
    Route::get('homepage-header', 'HomepageApi@getHeader');
    Route::get('school-info', 'HomepageApi@schoolInfo');
});


/**
 * Api access for Backend
 */
Route::group(['namespace' => 'Api\Backend', 'middleware' => 'auth:api'], function () {
    // Api for contact
    Route::get('contact', 'ContactApi@getContact')->name('api.contact');
    Route::post('contact-update', 'ContactApi@updateContact')->name('api.contact-update');
    // Api for Profile
    Route::get('profile', 'ProfileApi@getProfile')->name('api.profile');
    Route::post('submit-profile', 'ProfileApi@submitProfile')->name('api.submit-profile');
    Route::post('update-profile', 'ProfileApi@updateProfile')->name('api.update-profile');
    // Api for Teacher
    Route::get('teacher', 'TeacherApi@getTeacher')->name('api.teacher');
    Route::post('submit-teacher', 'TeacherApi@storeData')->name('api.store-teacher');
    Route::post('update-teacher', 'TeacherApi@updateData')->name('api.update-teacher');
    Route::post('delete-teacher/{id}', 'TeacherApi@deleteData')->name('api.delete-teacher');
    // Api for Program
    Route::get('program', 'ProgramApi@getProgram')->name('api.program');
    Route::post('submit-program', 'ProgramApi@storeData')->name('api.store-program');
    Route::post('update-program', 'ProgramApi@updateData')->name('api.update-program');
    Route::post('delete-program/{id}', 'ProgramApi@deleteData')->name('api.delete-program');
    //Api for Student
    Route::get('student', 'StudentApi@getStudent')->name('api.student');
    Route::post('submit-student', 'StudentApi@storeData')->name('api.store-student');
    Route::post('update-student', 'StudentApi@updateData')->name('api.update-student');
    Route::post('delete-student/{id}', 'StudentApi@deleteData')->name('api.delete-student');
    // //Api for Achievement
    Route::get('achievement', 'AchievementApi@getAchievement')->name('api.achievement');
    Route::post('submit-achievement', 'AchievementApi@storeData')->name('api.store-achievement');
    Route::post('update-achievement', 'AchievementApi@updateData')->name('api.update-achievement');
    Route::post('delete-achievement/{id}', 'AchievementApi@deleteData')->name('api.delete-achievement');
    Route::post('show-achievement/{id}', 'AchievementApi@showData')->name('api.show-achievement');
    Route::post('publish-achievement/{id}', 'AchievementApi@publishData')->name('api.publish-achievement');
    Route::post('unpublish-achievement/{id}', 'AchievementApi@unpublishData')->name('api.unpublish-achievement');
    //Api for Account
    Route::get('account', 'AccountApi@getAccount')->name('api.account');
    Route::post('submit-account', 'AccountApi@storeData')->name('api.store-account');
    Route::post('update-account', 'AccountApi@updateData')->name('api.update-account');
    Route::post('delete-account/{id}', 'AccountApi@deleteData')->name('api.delete-account');
    Route::post('reset-account/{id}', 'AccountApi@resetAccount')->name('api.reset-account');
    //Api for Event
    Route::get('event', 'EventApi@getEvent')->name('api.event');
    Route::post('submit-event', 'EventApi@storeData')->name('api.store-event');
    Route::post('update-event', 'EventApi@updateData')->name('api.update-event');
    Route::post('delete-event/{id}', 'EventApi@deleteData')->name('api.delete-event');
    Route::post('publish-event/{id}', 'EventApi@publishData')->name('api.publish-event');
    Route::post('unpublish-event/{id}', 'EventApi@unpublishData')->name('api.unpublish-event');
    //Api for Category
    Route::get('category', 'CategoryApi@getCategory')->name('api.category');
    Route::post('submit-category', 'CategoryApi@storeData')->name('api.store-category');
    Route::post('update-category', 'CategoryApi@updateData')->name('api.update-category');
    Route::post('delete-category/{id}', 'CategoryApi@deleteData')->name('api.delete-category');
    // Api for info dashboard
    Route::get('total-info', 'AccountApi@getTotal')->name('api.total');
    // Api for pengantar
    Route::get('intro', 'profileApi@getIntro')->name('api.intro');
    Route::post('intro-update', 'profileApi@updateIntro')->name('api.intro-update');
    // Api for gallery
    Route::get('gallery/{album_id}', 'galleryApi@getGallery')->name('api.gallery');
    Route::post('submit-gallery/{album_id}', 'galleryApi@submitGallery')->name('api.submit-gallery');
    Route::delete('delete-gallery/{id}', 'galleryApi@deleteGallery')->name('api.delete-gallery');
    // Api for album
    Route::get('album', 'albumApi@getAlbum')->name('api.album');
    Route::post('submit-album', 'albumApi@submitAlbum')->name('api.submit-album');
    Route::delete('delete-album/{id}', 'albumApi@deleteAlbum')->name('api.delete-album');
    Route::patch('update-album/{id}', 'albumApi@updateAlbum')->name('api.update-album');
});