<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
