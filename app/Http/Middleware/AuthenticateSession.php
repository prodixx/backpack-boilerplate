<?php

namespace App\Http\Middleware;

use Backpack\CRUD\app\Http\Middleware\AuthenticateSession as BackpackAuthenticateSession;
use Closure;

/**
 * Laravel 13's SessionGuard stores an HMAC of the password hash in the session
 * and in the remember-me cookie, while Backpack's middleware (7.1.20) compares
 * against the raw hash and logs the user out after every login.
 * This accepts both formats, the same way Laravel's own AuthenticateSession does.
 */
class AuthenticateSession extends BackpackAuthenticateSession
{
    public function handle($request, Closure $next)
    {
        if (! $request->hasSession() || ! $this->user) {
            return $next($request);
        }

        if ($this->guard()->viaRemember()) {
            $passwordHash = explode('|', $request->cookies->get($this->guard()->getRecallerName()))[2] ?? null;

            if (! $passwordHash || ! $this->validatePasswordHash($this->user->getAuthPassword(), $passwordHash)) {
                $this->logout($request);
            }
        }

        if (! $request->session()->has('password_hash_'.backpack_guard_name())) {
            $this->storePasswordHashInSession($request);
        }

        if (! $this->validatePasswordHash($this->user->getAuthPassword(), (string) $request->session()->get('password_hash_'.backpack_guard_name()))) {
            $this->logout($request);
        }

        return tap($next($request), function () use ($request) {
            if (! is_null($this->guard()->user())) {
                $this->storePasswordHashInSession($request);
            }
        });
    }

    protected function storePasswordHashInSession($request)
    {
        if (! $this->user) {
            return;
        }

        $request->session()->put([
            'password_hash_'.backpack_guard_name() => $this->guard()->hashPasswordForCookie($this->user->getAuthPassword()),
        ]);
    }

    protected function validatePasswordHash($passwordHash, $storedValue)
    {
        return hash_equals($this->guard()->hashPasswordForCookie($passwordHash), $storedValue)
            || hash_equals($passwordHash, $storedValue);
    }

    protected function guard()
    {
        return $this->auth->guard(backpack_guard_name());
    }
}
