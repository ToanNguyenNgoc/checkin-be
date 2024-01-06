<?php
namespace App\Services\Api;

use App\Repositories\User\UserRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Services\BaseService;

class AuthService extends BaseService
{
    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function authenticate()
    {
        $this->ensureIsNotRateLimited((object)$this->attributes);

        $credentials['email'] = trim($this->attributes['email']);
        $credentials['password'] = trim($this->attributes['password']);

        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($this->throttleKey());
            return false;
        }

        if ($this->repo->checkValidUserStatusByEmail($credentials['email'])) {
            $this->repo->user()->update([
                'last_login_at' => now()->toDateTimeString(),
            ]);

            RateLimiter::clear($this->throttleKey());
            return true;
        }

        Auth::logout();
        return false;

        /* throw ValidationException::withMessages([
            'email' => ['Invalid user status for login.'],
        ]); */
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited($attributes)
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($attributes));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->attributes['email']).'|'.request()->ip();
    }
}
