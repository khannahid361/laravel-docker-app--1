<?php

namespace App\Providers;

use App\Repositories\Authentication\{UserAuthenticationRepository, UserAuthenticationRepositoryInterface};
use App\Repositories\Post\{PostRepository, PostRepositoryInterface};
use App\Repositories\Comment\{CommentRepository, CommentRepositoryInterface};
use App\Models\{Post, Comment};
use App\Policies\{PostPolicy, CommentPolicy};
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserAuthenticationRepositoryInterface::class,
            UserAuthenticationRepository::class
        );

        $this->app->bind(
            PostRepositoryInterface::class,
            PostRepository::class
        );

        $this->app->bind(
            CommentRepositoryInterface::class,
            CommentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip());
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(3)
                ->by($request->ip());
        });
    }
}
