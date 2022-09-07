<?php

namespace App\Providers;

use App\Models\Biggapon;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Setting;
use App\Models\SocialIcon;
use Illuminate\Support\ServiceProvider;
use View,MyHelper,Auth,DataLoad;

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

        View::composer( // for admin menu --------------
            [
                'admin.includes.aside',
            ],
            function ($view)
            {
                $menus=Menu::with('activeSubMenu')->where(['menu_for'=>Menu::ADMIN_MENU,'status'=>Menu::ACTIVE])->orderBy('serial_num','ASC')->get();

                $view->with(['menus'=>$menus]);
            });


        View::composer( // for frontend Home --------------
            [
                'client.index',
            ],
            function ($view)
            {
                $setting=$setting=DataLoad::setting();

                $bongobondhoBangladeshCatBooks=Product::filterCategoryProducts(['status'=>Product::PUBLISHED,'show_home'=>Product::YES],
                    ['bongobondho','bangladesh','liberation-war'])->take(20)
                    ->orderBy('products.id','DESC')->get();

                $bongobondhoPopularCatBooks=Product::filterCategoryProducts(['status'=>Product::PUBLISHED,'show_home'=>Product::YES],
                    ['bangabandhu-popular'])->take(20)
                    ->orderBy('products.id','DESC')->get();

                $StoriesNovelPoemsCatBooks=Product::filterCategoryProducts(['status'=>Product::PUBLISHED,'show_home'=>Product::YES],
                    ['story','novel','poetry'])->take(20)
                    ->orderBy('products.id','DESC')->get();

                $view->with(['setting'=>$setting,
                    'bongobondhoBangladeshCatBooks'=>$bongobondhoBangladeshCatBooks,
                    'bongobondhoPopularCatBooks'=>$bongobondhoPopularCatBooks,
                    'StoriesNovelPoemsCatBooks'=>$StoriesNovelPoemsCatBooks,
                ]);
            });

        View::composer( // for frontend Footer --------------
            [
                'client.layouts.partials.footer',
            ],
            function ($view)
            {
                $setting=Setting::first();
                $socials=SocialIcon::orderBy('serial_num','ASC')->where('status',SocialIcon::ACTIVE)->get();

                $view->with(['setting'=>$setting,'socials'=>$socials]);
            });
    }
}
