<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AdvertisementRepository;
use App\Repositories\GlobalRepository;
use App\Helpers\PaperGenerator;
use App\Helpers\PaperManager;
use App\Helpers\RankingManager;
use App\Helpers\ReportManager;
use Encore\Admin\Facades\Admin;
use App\Contracts\Cache\Competition as CompetitionCache;
use App\Caches\Redis\CompetitionCache as RedisCompetitonCache;
use App\Admin\Models\Season;
use App\Observers\SeasonObserver;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\Paper;
use App\Observers\PaperObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        \Laravel\Horizon\Horizon::auth(function () {
            // use Laravel-Admin Auth for Horizon authorizetion
            return (Admin::user()) ? true : false;
        });

        $global = GlobalRepository::getGlobal();
        View::share('global', $global);

        // Share advertisement to all views
        $advertisements = (new AdvertisementRepository())->getList();
        View::share('advertisements', $advertisements);

        // Share ranking data to all views if global ranking status was enable
        // if ($global->rank_status == 1) {
        //     $seasonId = $global->ranking_season ?? (season()->id ?? 1);
        //     $rankingData = (new RankingManager())->setSeasonId($seasonId)->getAllRanking();

        //     View::share('rankingData', $rankingData);
        // }

        $this->registerObservers();
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        // if (config('app.debug')) {
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        // }

        $this->app->bind('PaperGenerator', PaperGenerator::class);
        $this->app->bind('PaperManager', PaperManager::class);
        $this->app->bind('RankingManager', RankingManager::class);
        $this->app->bind('ReportManager', ReportManager::class);
        $this->app->bind(CompetitionCache::class, RedisCompetitonCache::class);
    }

    /**
     * Register any model observers.
     */
    public function registerObservers()
    {
        Season::observe(SeasonObserver::class);
        User::observe(UserObserver::class);
        Paper::observe(PaperObserver::class);
    }
}
