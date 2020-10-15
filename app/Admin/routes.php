<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->get('ranking', 'RankingController@index')->name('admin.ranking');

    // customize login
    $router->get('auth/login', 'AuthController@getLogin');
    $router->post('auth/login', 'AuthController@postLogin');
    $router->get('auth/logout', 'AuthController@getLogout');

    // customize modules
    $router->resource('general-setting', GeneralSettingController::class);
    $router->resource('users', UsersController::class);
    $router->resource('posts', PostController::class);
    $router->resource('categories', CategoryController::class);
    $router->resource('adv-type', AdvTypeController::class);
    $router->resource('adv-list', AdvListController::class);
    $router->resource('promo-setting', FeatureController::class);
    $router->resource('promo-articles', FeaturePostsController::class);
    $router->resource('pages', PageController::class);
    $router->resource('competition-info', CompetitionInfoController::class);
    $router->resource('sponsors', SponsorController::class);
    $router->resource('references', ReferenceController::class);
    $router->resource('question-categories', QuestionCategoryController::class);
    $router->resource('scopes', ScopeController::class);
    $router->resource('questions', QuestionController::class);
    $router->resource('seasons', SeasonController::class);
    $router->resource('papers', PaperController::class);
    $router->resource('schools', SchoolController::class);
    $router->resource('school-registrations', SchoolRegistrationController::class);
    $router->resource('students', ParticipantController::class);
    $router->resource('enquiries', EnquiryController::class);
    $router->resource('consultants', ConsultantController::class);
    
    // backend upload function
    $router->post('/posts/upload', 'PostController@upload');
    $router->post('/pages/upload', 'PageController@upload');

    $router->post('/editor/image-upload', 'UploadController@uploadImage')->name('editor.upload_image'); //CKEditor image upload

    $router->get('export', 'ExportController@export')->name('admin.export');
});
