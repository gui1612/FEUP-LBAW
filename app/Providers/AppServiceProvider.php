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

        Blade::directive('danger', function () {
            // $expression = Blade::stripParentheses($expression);
            return '<?php if (session()->has(\'danger\')):
if (isset($danger)) { $__dangerOriginal = $danger; }
function danger($key) { return session()->get(\'danger\')[$key] ?? null; }
?>';
        });

        Blade::directive('enddanger', function () {
            return '<?php unset($danger);
if (isset($__dangerOriginal)) { $danger = $__dangerOriginal; }
endif; ?>';
        });
    }
}
