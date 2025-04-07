<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register custom login response handler to show success message
        $this->app->instance(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            new class implements \Laravel\Fortify\Contracts\LoginResponse {
                public function toResponse($request)
                {
                    if (session('password_reset_required')) {
                        session()->forget('password_reset_required');
                        return redirect()->route('password.request')
                            ->with('status', 'Please set a new password for your account.');
                    }
                    
                    // No need to set success message here as it's set in authenticateUsing
                    return redirect()->intended('/dashboard');
                }
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Handle login errors by modifying the login view
        Fortify::loginView(function () {
            if (session('login_error')) {
                session()->flash('error', session('login_error'));
                session()->forget('login_error');
            }
            return view('auth.login');
        });

        // Custom authentication logic
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
            
            if ($user && Hash::check($request->password, $user->password)) {
                // Check if user is allowed to login
                if (!$user->can_login) {
                    session(['login_error' => 'Your account is currently inactive. Please contact the administrator.']);
                    throw ValidationException::withMessages([
                        'email' => ['Your account is currently inactive. Please contact the administrator.'],
                    ]);
                }
                
                if ($user->last_login_at === null) {
                    session(['password_reset_required' => true]);
                }
                
                // Update last login timestamp
                $user->last_login_at = now();
                $user->save();
                
                // Set login success message in session
                session()->flash('success', 'Login successful! Welcome back.');
                
                return $user;
            }
            
            // Set general error message for invalid credentials
            session(['login_error' => 'Invalid credentials. Please try again.']);
            
            return null;
        });

        // Rate limiter configuration
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}