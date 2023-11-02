<?php

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

Route::namespace('Api')->group(function () {
    Route::post('login', 'CompetitionController@login')->name('competition.login');
    Route::post('user', 'CompetitionController@getUser')->name('competition.user');
    Route::post('logout', 'CompetitionController@logout')->name('competition.logout');

    Route::middleware('auth')->group(function () {
        Route::prefix('users')->group(function () {
            Route::post('stats', 'UserStatController@store')->name('user.stat.store');
            Route::post('response-time', 'ResponseTimeController@store')->name('user.response_time');
        });

        Route::middleware([
            'CheckUserPaperExists:initialize',
        ])->post('initialize', 'CompetitionController@initialize')->name('competition.initialize');

        Route::middleware([
            'CheckUserPaperExists:question',
            'CheckPaperTimeout',
            'CheckQuestionTimeout',
        ])->post('question', 'CompetitionController@getQuestion')->name('competition.get_question');

        Route::middleware(['CheckUserPaperExists:question', 'CheckPaperTimeout'])
            ->post('question/submit', 'CompetitionController@submitAnswer')->name('competition.submit_answer');

        Route::post('result', 'CompetitionController@getResult')->name('competition.result');

        Route::prefix('participate-session')->group(function () {
            Route::post('register', 'CompetitionController@registerParticipateSession')
                    ->name('competition.participate_session.register');

            Route::post('remove', 'CompetitionController@removeParticipateSession')
                    ->name('competition.participate_session.remove');
        });
    });
});

Route::post('question/import', 'QuestionImportController@import')->name('question.import');
