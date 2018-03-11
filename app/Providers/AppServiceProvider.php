<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

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
