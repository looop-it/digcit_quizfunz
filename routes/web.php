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

Auth::routes();

Route::get('/', 'IndexController@index')->name('home');

Route::get('register/success', 'Auth\RegisterController@success')->name('register.success');

Route::prefix('user')->group(function () {
    Route::middleware(['auth.verified'])->get('/', 'UserController@index')->name('user');
    Route::get('msg', 'UserController@msg');     //提示

    Route::get('verify', 'UserController@verify')->name('user.verify');
    Route::get('not-verified', 'UserController@notVerified')->name('user.not_verified');
    Route::post('verifiy/resend', 'UserController@resendVerificationToken')->name('user.resend_verification_token');
});

Route::prefix('school')->group(function () {
    Route::get('register', 'SchoolRegistrationController@show')->name('school_registration.show');
    Route::get('registered', 'SchoolRegistrationController@registered')->name('school_registration.registered');
    Route::post('register', 'SchoolRegistrationController@store')->name('school_registration.store');
    
    Route::get('verify', 'SchoolRegistrationController@verify')->name('school_registration.verify');
    Route::get('verified', 'SchoolRegistrationController@verified')->name('school_registration.verified');
});

Route::get('/news', 'NewsController@index')->name('news');     //最新消息列表
Route::get('/news/newsdetail/{id}', 'NewsController@newsDetail')->name('news.detail');      //最新消息詳細

Route::get('/ranking', 'RankingController@index')->name('ranking');     //排行                   match-play

// Competition Detail
Route::prefix('information')->group(function () {
    Route::get('/', 'InformationController@index')->name('information');
});

// References
Route::prefix('references')->group(function () {
    Route::get('/', 'ReferenceController@index')->name('references');
    Route::get('{id}', 'ReferenceController@show')->name('references.detail');
});

Route::get('/pages/{slug?}', 'PagesController@index')->name('page.detail');
Route::post('/pages/enquiry', 'PagesController@enquiry');    //  查詢

Route::post('/valid/school', 'ValidController@validSchool');

Route::prefix('competition')->middleware(['auth', 'auth.verified'])->group(function () {
    Route::get('participate', 'ParticipantController@participate')->name('participant.participate');
    Route::post('participate', 'ParticipantController@store')->name('participant.store');
    Route::post('validate', 'ParticipantController@validateCode')->name('participant.validate');

    Route::middleware([
        // 'CheckIsMobile',
        'VerifyParticipantInfo',
        'CheckOpenSeason',
        'CheckCompetitionTime',
        'CheckTimesLimit',
        'CheckDailyTimesLimit',
        'CheckTimeInterval',
        'RedirectIfParticipateCacheExists',
    ])->get('start', 'CompetitionController@start')->name('competition.start');

    Route::get('result', 'CompetitionController@result')->name('competition.result');

    Route::get('records', 'CompetitionController@getRecords')->name('competition.records');

    Route::get('error', 'CompetitionController@error')->name('competition.error');
});
