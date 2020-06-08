<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // listening/checking if the product quantity is zero or not, if zero change the status to unavailable
        Product::updated(function($product)
        {
            if($product->quantity == 0 && $product->isAvailable())
            {
                $product->status = Product::UNAVAILABLE_PRODUCT;
                $product->save();
            }
        });

        // send a verification email to the user email after creation
        User::created(function($user)
        {
            Mail::to($user)->send(new UserCreated($user));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
