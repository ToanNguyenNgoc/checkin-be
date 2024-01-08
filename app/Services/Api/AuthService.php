<?php
namespace App\Services\Api;

use App\Repositories\User\UserRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Services\BaseService;

class AuthService extends BaseService
{
    protected $seconds;
    protected $maxAttempts = 5;
    protected $decaySeconds = 1;

    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function authenticate()
    {
        if (!$this->ensureIsNotRateLimited((object)$this->attributes)) {
            return [
                'auth'  => false,
                'msg'   => trans('_auth.throttle', [
                    'seconds'   => $this->seconds,
                    'minutes'   => ceil($this->seconds/$this->decaySeconds),
                ])
            ];
        }

        $credentials['email'] = trim($this->attributes['email']);
        $credentials['password'] = trim($this->attributes['password']);

        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($this->throttleKey());
            return [
                'auth'  => false,
                'msg'   => __('auth.failed')
            ];
        }

        if ($this->repo->checkValidUserStatusByEmail($credentials['email'])) {
            $this->repo->user()->update([
                'last_login_at' => now()->toDateTimeString(),
            ]);

            RateLimiter::clear($this->throttleKey());
            return [
                'auth'  => true,
                'msg'   => trans('_auth.success')
            ];
        }

        Auth::logout();
        return [
            'auth'  => false,
            'msg'   => __('auth.failed')
        ];

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
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), $this->maxAttempts)) {
            return true;
        }

        $this->seconds = RateLimiter::availableIn($this->throttleKey());
        return false;

        throw ValidationException::withMessages([
                'email'     => trans('_auth.throttle', [
                'seconds'   => $this->seconds,
                'minutes'   => ceil($this->seconds/$this->decaySeconds),
            ]),
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
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
