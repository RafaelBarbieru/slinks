<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use DomDocument;

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
        Blade::directive('svg', function($arguments) {
            // Funky madness to accept multiple arguments into the directive
            list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path = trim($path, "' ");
            $class = trim($class, "' ");
    
            // Create the dom document as per the other answers
            $svg = new DOMDocument();
            $svg->load(public_path($path));
            $svg->documentElement->setAttribute("class", $class);
            $output = $svg->saveXML($svg->documentElement);
    
            return $output;
        });

        if(config('app.env') === 'production' || config('app.env') === 'staging') {
            \URL::forceScheme('https');
        }
    }
}
