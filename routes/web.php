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

use Illuminate\Http\Request;

Route::get('/', 'IndexController@index')->name('home');

Route::prefix('login')->group(function () {
    Route::get('/', function (Request $request) {
        $redirectUrl = $request->session()->pull('redirectUrl', null);

        return redirect(sso_url('login', $redirectUrl));
    })->name('login');

    Route::get('/callback', 'Auth\SSOLoginController@callback');
});

Route::get('logout', 'Auth\SSOLoginController@logout')->name('logout');

Route::get('register/success', 'Auth\RegisterController@success')->name('register.success');

Route::prefix('user')->group(function () {
    Route::middleware(['auth.verified'])->get('/', 'UserController@index')->name('user');
    Route::get('msg', 'UserController@msg');     //提示
    Route::get('profile', 'UserController@profile')->name('user.profile');
    
    Route::get('verify', 'UserController@verify')->name('user.verify');
    Route::get('not-verified', 'UserController@notVerified')->name('user.not_verified');
    Route::post('verifiy/resend', 'UserController@resendVerificationToken')->name('user.resend_verification_token');
});

Route::prefix('school')->group(function () {
    Route::get('register', 'SchoolRegistrationController@show')->name('school_registration.show');
    Route::get('registered', 'SchoolRegistrationController@registered')->name('school_registration.registered');
    Route::middleware('google-recaptcha-v2')->post('register', 'SchoolRegistrationController@store')->name('school_registration.store');

    Route::get('verify', 'SchoolRegistrationController@verify')->name('school_registration.verify');
    Route::get('verified', 'SchoolRegistrationController@verified')->name('school_registration.verified');

//     Route::get('import', 'StudentAccountImportController@index')->name('student_account_import.index');
//     Route::middleware('google-recaptcha-v2')->post('import/login', 'StudentAccountImportController@login')->name('student_account_import.login');
//     Route::post('import', 'StudentAccountImportController@store')->name('student_account_import.store');
//     Route::post('import/logout', 'StudentAccountImportController@logout')->name('student_account_import.logout');
});

Route::prefix('news')->group(function () {
    Route::get('/', 'NewsController@index')->name('news');     //最新消息列表
    Route::get('{id}', 'NewsController@show')->name('news.detail');      //最新消息詳細
});

Route::get('/ranking', 'RankingController@index')->name('ranking');     //排行                   match-play

// Competition Detail
Route::prefix('information')->group(function () {
    Route::get('/', 'InformationController@index')->name('information');
});

// References
Route::prefix('references')->group(function () {
    Route::get('/', 'ReferenceController@index')->name('references');
    Route::get('{reference}', 'ReferenceController@show')->name('references.detail');
});

Route::prefix('pages')->group(function () {
    Route::get('{slug?}', 'PagesController@index')->name('page.detail');
});

// Enquiry
Route::prefix('enquiry')->group(function () {
    Route::get('/', 'EnquiryController@form')->name('enquiry');
    Route::middleware('google-recaptcha-v2')->post('/', 'EnquiryController@store')->name('enquiry.store');
    Route::get('/submitted', 'EnquiryController@submitted')->name('enquiry.submitted');
});

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
    ])->group(function () {
        Route::get('start', 'CompetitionController@start')->name('competition.start');
        Route::post('page-answer', 'PageAnswerController@submit')->name('competition.page.submit');
    });

    Route::get('result', 'CompetitionController@result')->name('competition.result');
    Route::get('records', 'CompetitionController@getRecords')->name('competition.records');
    Route::get('error', 'CompetitionController@error')->name('competition.error');
});
