<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Masbug\Flysystem\GoogleDriveAdapter;

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('google-drive', function() {
            return new GoogleDriveAdapter(
                config('filesystems.disks.google')
            );
        });
    }
}