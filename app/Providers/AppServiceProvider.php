<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // ...

        /**
         * Gate ini hanya akan memberikan akses jika role user adalah 'pengurus'.
         */
        Gate::define('manage-library', function (User $user) {
            return $user->isPengurus();
        });

        /**
         * Gate ini hanya akan memberikan akses jika role user adalah 'siswa'.
         */
        Gate::define('borrow-books', function (User $user) {
            return $user->isSiswa();
        });
    }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
