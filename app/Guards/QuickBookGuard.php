<?php

namespace App\Guards;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Session;

class QuickBookGuard implements Guard
{
    use GuardHelpers;

    /**
     * @var string|mixed|null
     */
    protected ?string $quickBookToken;

    /**
     * @var int|null
     */
    protected $tokenExpiry;

    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
        $this->tokenExpiry = Session::get('quick_book_access_token_expiry');
        $this->quickBookToken = Session::get('quick_book_access_token');
    }

    public function check(): bool
    {
        return $this->quickBookToken !== null && now()->lessThan($this->tokenExpiry);
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return $this->quickBookToken ? $this->provider->retrieveById($this->quickBookToken) : null;
    }

    public function validate(array $credentials = []): bool
    {
        return ! empty($this->quickBookToken);
    }

    public function setQuickBookToken(
        string $token
    ): void {
        $this->quickBookToken = $token;
        $this->tokenExpiry = now()->addHour();

        Session::put('quick_book_access_token', $this->quickBookToken);
        Session::put('quick_book_access_token_expiry', $this->tokenExpiry);
    }

    /**
     * retrieve the Quickbooks access token
     *
     * @return mixed
     */
    public function getQuickBookToken()
    {
        return $this->quickBookToken;
    }

    public function logout()
    {
        Session::forget(['quick_book_access_token', 'quick_book_access_token_expiry']);
    }
}
