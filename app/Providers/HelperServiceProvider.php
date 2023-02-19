<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $allhelpersFiles = glob(app_path('Helpers') . '/*.php');
        foreach ($allhelpersFiles as $key => $helperFile) {
            require_once $helperFile;
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
}
