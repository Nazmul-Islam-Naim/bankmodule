<?php
namespace App\Services;

use App\Authentication\Authenticators\Authenticator;
use App\Authentication\Login;
use Illuminate\Auth\AuthenticationException;
use Exception;

class AuthService
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminLogin()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('admin')->attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerLogin()
    {
        $credentials = request(['phone', 'password']);

        if (! $token = auth('customer')->attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials');
        }

        return $this->respondWithToken($token);
    }

     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function vendorLogin()
    {
        $credentials = request(['phone', 'password']);

        if (! $token = auth('vendor')->attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return auth()->user();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return auth()->logout();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin')->factory()->getTTL() * 60
        ];
    }

}
