<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        Schema::defaultStringLength(191);
      Paginator::useBootstrap();
      
    
      
      //compose all the views....
    view()->composer('layouts.main_navbar', function ($view) 
    {
        
         if( Auth::user()->added_by ==  Auth::user()->id){
         $countUnreadNotifications = Notification::where('added_by', Auth::user()->added_by)->where('read','0')->count();;
         }
         
         else{
            $countUnreadNotifications = Notification::where('added_by',Auth::user()->added_by)->where('from_user_id',Auth::user()->id)->orWhere->where('added_by',Auth::user()->added_by)->where('to_user_id',Auth::user()->id)->where('read','0')->count();;  
         }
        
       
        $view->with('countUnreadNotifications', $countUnreadNotifications);    
    });  
      
      
      
      
     
        //
    }
}
