<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Inertia;

class QuickBookController extends Controller
{
    /**
     * quickbook client id
     */
    protected string $quickBookClientId;

    /**
     * quickbook client secret
     */
    protected string $quickBookClientSecret;

    /**
     * quickbook oauth redirect uri
     */
    protected string $quickBookRedirectUri;

    /**
     * quickbook oauth base url
     */
    protected PendingRequest $quickBookOAuthHttpClient;

    /*
     * quickbook token url
     */
    protected PendingRequest $quickbookTokenUrl;

    /**
     * quickbook oauth base url
     */
    protected PendingRequest $quickBookHttpClient;

    /**
     * quickbook books oauth scopes
     */
    protected string $quickBookOAuthScope;

    public function __construct()
    {
        // configure quickbook credentials
        $this->quickBookClientId = config('services.quickbook.client_id');
        $this->quickBookClientSecret = config('services.quickbook.client_secret');
        $this->quickBookRedirectUri = config('services.quickbook.redirect');
        $this->quickBookOAuthScope = config('services.quickbook.quick_book_oauth_scope');

        // macro http client for quickbook
        $this->quickbookTokenUrl = Http::baseUrl(config('services.quickbook.token_base_url'));
        $this->quickBookOAuthHttpClient = Http::quickbookOAuth();
        $this->quickBookHttpClient = Http::quickbook();
    }

    /**
     * authenticate from quickbook oauth
     */
    public function redirectToQuickBook(): RedirectResponse
    {
        // set up the url to redirect
        $authUrl = config('services.quickbook.auth_base_url');

        $state = Str::random(40);
        Session::put('oauth2state', $state);

        // set up the query params
        $queryParams = http_build_query([
            'client_id' => $this->quickBookClientId,
            'redirect_uri' => $this->quickBookRedirectUri,
            'scope' => $this->quickBookOAuthScope,
            'response_type' => 'code',
            'state' => $state
        ]);

        return redirect($authUrl.'?'.$queryParams);
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Auth/QuickBookLogin');
    }

    /**
     * @return RedirectResponse|\Inertia\Response
     */
    public function handleQuickBookCallback(Request $request)
    {
        $code = $request->query('code');
        $companyId = $request->query('realmId');
        Session::put("company_id", $companyId);

        if (! $code) {
            return Inertia::render('Auth/QuickBookLogin', [
                'status' => 'Something went wrong with the authorization. Code does not exist.',
            ]);
        }

        try {
            // send request to quickbook to get obtain access token
            $response = $this->quickbookTokenUrl
                ->asForm()
                ->post('/tokens/bearer', [
                    'grant_type' => 'authorization_code',
                    'client_id' => $this->quickBookClientId,
                    'client_secret' => $this->quickBookClientSecret,
                    'redirect_uri' => $this->quickBookRedirectUri,
                    'code' => $code,
                    'scope' => $this->quickBookOAuthScope,
                    'state' => 'online',
                ])
                ->json();

            if (! isset($response['access_token'])) {
                return Inertia::render('Auth/QuickBookLogin', [
                    'status' => 'Failed to authenticate with Quickbooks',
                ]);
            }

            $accessToken = $response['access_token'];

            // add token to quickbook guard
            Auth::guard('quickbook')
                ->setQuickBookToken($accessToken);

            return Inertia::location('/quickbook/dashboard');


        } catch (\Exception $e) {

            return redirect()
                ->intended(route('quick-books-oauth.index'))
                ->with('error', 'Failed to authenticate with Quickbooks.');
        }
    }

    public function destroyQuickBookToken()
    {
        Auth::guard('quickbook')->logout();

        return redirect()->intended(
            route('quickbook-oauth.index')
        );
    }
}
