<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        

        FilamentAsset::register([
            Css::make('colors', Vite::useHotFile('app')
            ->asset('resources/css/app.css','build'))
        ]);



        Blade::directive('viewPath', function () {
            return "<?php echo e(view()->getPath()); ?>";
        });
    }
}
