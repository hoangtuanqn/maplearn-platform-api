<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
use App\Policies\PostPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::policy(Post::class, PostPolicy::class);
        Carbon::setLocale('vi');
        App::setLocale('vi'); // nếu bạn đang dùng `trans()` hay đa ngôn ngữ Laravel

        Post::observe(PostObserver::class); // Đăng ký observer cho model Post


    }
}
