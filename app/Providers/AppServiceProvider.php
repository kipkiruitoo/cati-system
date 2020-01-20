<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Events\Dispatcher;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Voyager::addAction(\App\Actions\EditSurvey::class);
        \Response::macro('attachment', function ($content, $filename) {

            $headers = [
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
            ];

            return \Response::make($content, 200, $headers);
        });
    }
}
