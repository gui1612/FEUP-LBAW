<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;


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
        if(env('FORCE_HTTPS',false)) {
            error_log('configuring https');
            $app_url = config("app.url");
            URL::forceRootUrl($app_url);
            $schema = explode(':', $app_url)[0];
            URL::forceScheme($schema);
        }

        Paginator::useBootstrapFive();

        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->is_admin;
        });

        Blade::directive('foreachtoast', function () {
            return '<?php if (session()->has(\'toasts\')):
if (isset($type)) { $__typeOriginal = $type; }
if (isset($category)) { $__categoryOriginal = $category; }
if (isset($message)) { $__messageOriginal = $message; }
foreach (session()->get(\'toasts\') as $key => $toast):
$type = $toast[\'type\'];
$category = $toast[\'category\'];
$message = $toast[\'message\'];?>';
        });

        Blade::directive('endforeachtoast', function () {
            return '<?php endforeach;
unset($type);
unset($category);
unset($message);
if (isset($__typeOriginal)) { $type = $__typeOriginal; }
if (isset($__categoryOriginal)) { $category = $__categoryOriginal; }
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
?>';
        });
    }
}
