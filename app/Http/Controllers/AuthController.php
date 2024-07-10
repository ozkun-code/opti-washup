<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class AuthController extends Controller
{
    /**
     * User registration
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $userData = $request->validated();
        $userData['email_verified_at'] = now();
        $user = User::create($userData);

        $response = Http::post(env('APP_URL') . '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_SECRET'),
            'username' => $userData['email'],
            'password' => $userData['password'],
            'scope' => '',
        ]);

        $user['token'] = $response->json();

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'User has been registered successfully.',
            'data' => $user,
        ], 201);
    }

    /**
     * Login user
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $response = Http::post(env('APP_URL') . '/oauth/token', [
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ]);

            $user['token'] = $response->json();

            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'User has been logged successfully.',
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'statusCode' => 401,
                'message' => 'Unauthorized.',
                'errors' => 'Unauthorized',
            ], 401);
        }
    }

    /**
     * Get authenticated user info
     */
    public function me(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Authenticated user info.',
            'data' => $user,
        ], 200);
    }

    /**
     * Refresh access token
     */
    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {
        $response = Http::asForm()->post(env('APP_URL') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_SECRET'),
            'scope' => '',
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Refreshed token.',
            'data' => $response->json(),
        ], 200);
    }

    /**
     * Logout user
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens->each(function ($token, $key) {
            $this->revokeAccessAndRefreshTokens($token->id);
        });

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Logged out successfully.',
        ], 200);
    }

    /**
     * Revoke access and refresh tokens
     */
    protected function revokeAccessAndRefreshTokens($tokenId)
    {
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $tokenRepository->revokeAccessToken($tokenId);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
    }
}
