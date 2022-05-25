<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Rider;
use App\Enums\ActiveStatus;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class RiderAuthController extends Controller
{
        /**
     * Register a new seller on the application
     *
     * @param \Illuminate\Http\Request $request
     */
    public function register(Request $request)
    {
        // Validate the request
        $validated = $this->validate($request, [
            'zoneId'                   => 'required',
            'firstName'                => 'required|string|between:2,100',
            'lastName'                 => 'required|string|between:2,100',
            'email'                    => 'required|email|max:100|unique:riders',
            'phone'                    => 'required|string|max:15|unique:riders',
            'password'                 => 'required|string|confirmed|min:6',
        ]);

        $rider = Rider::create(array_merge(
            $request->only('firstName', 'lastName', 'email', 'phone', 'zoneId'),
            ['password' => bcrypt($request->password)]
        ));
        return new ApiResource($rider);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $this->validate(request(), [
            'phone' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['phone', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Phone or password is not correct'], 401);
        }

        // Update last login and status
        auth()->user()->update([
            'lastLogin' => Carbon::now(),
            'status'    => ActiveStatus::ACTIVE()
        ]);

        return $this->respondWithToken($token);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
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
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
