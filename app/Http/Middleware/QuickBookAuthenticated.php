<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class QuickBookAuthenticated extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('quickbook')->check()) {
            return $next($request);
        }

        return redirect()
            ->intended(route('quickbook-oauth.index'))
            ->with('status', 'Quickbooks authentication required.');

    }

    /**
     * props to share with react components.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'quick_book_access_token' => Auth::guard('quickbook')->getQuickBookToken(),
            ],
        ];
    }
}
