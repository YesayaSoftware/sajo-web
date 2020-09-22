<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Client;

class LoginController extends Controller
{
    use IssueTokenTrait;
    private $client;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->client = Client::find(2);
    }

    /**
     * Login
     *
     * @param Request $request
     *
     * @return mixed
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        return $this->issueToken($request, 'password');
    }

    /**
     * Refresh token
     *
     * @param Request $request
     *
     * @return mixed
     *
     * @throws ValidationException
     */
    public function refresh(Request $request)
    {
        $this->validate($request, [
            'refresh_token' => 'required'
        ]);

        return $this->issueToken($request, 'refresh_token');
    }

    /**
     * Log user out, revoke access
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);
            
        $accessToken->revoke();

        return response()->json([], 204);
    }
}
