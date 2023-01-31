<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['layouts.*'],
            function ($view) {
                $menus = Menu::query()
                    ->with('childrens','permission', 'childrens.permission')
                    ->whereNull('parent_id')
                    ->get();
                    // dd($menus);
                $view->with([
                    'menus' => $menus
                ]);
            }
        );
    }
}
