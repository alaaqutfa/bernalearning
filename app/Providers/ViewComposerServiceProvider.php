<?php
namespace App\Providers;

use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('admin.layouts.app', function ($view) {
            $pendingOrdersCount = Order::whereIn('status', ['pending', 'payment_link_added', 'pending_review'])->count();
            $view->with('pendingOrdersCount', $pendingOrdersCount);
        });
    }
}
