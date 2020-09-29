<?php

namespace App\Providers;

use App\Http\ViewComposers\LatestNewsComposer;
use App\Http\ViewComposers\ReferenceMaterialComposer;
use App\Http\ViewComposers\FootComposer;
use App\Http\ViewComposers\NumStudentComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        /*     View::composer(
                 'profile', 'App\Http\ViewComposers\ProfileComposer'
             ); */

        View::composer(
            ['home.comm.latest_news','home.comm.new_first'],
            LatestNewsComposer::class
        );

        View::composer(
            'home.comm.referenceMaterial',
            ReferenceMaterialComposer::class
        );

        View::composer(
            'home.comm.foot',
            FootComposer::class
        );

        View::composer(
            'home.comm.numRoll',
            NumStudentComposer::class
        );

        View::composer('*', function ($view) {
            $view->with('user_data', Auth::user());
            $view->with('img_url', config('app.cdn_url'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
