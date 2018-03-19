<?php

namespace App\Providers;

use App\Observers\SceneObserver;
use App\Observers\UserObserver;
use App\Scene;
use App\User;
use App\ViewComposers\SidebarComposer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    private function setLanguage()
    {
        $locale = preg_replace('/[_-]\w+$/', '', Request::getPreferredLanguage());

        if (empty($locale) || !in_array($locale, array_keys(config('storylab.languages')))) {
            $locale = 'en';
        }

        App::setLocale($locale);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setLanguage();
        View::composer('partials.sidebar', SidebarComposer::class);

        Scene::observe(SceneObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
