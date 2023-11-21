<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        // Validate the login request
        $this->validateLogin($request);

        // Check login credentials
        if (!$this->guard()->attempt($this->credentials($request))) {
            // Failed login attempt
            return $this->sendFailedLoginResponse($request);
        }

        // Get the authenticated user
        $user = $this->guard()->user();

        // Create a token for the user
        $token = $user->createToken('TokenName')->plainTextToken;

        // Return token along with other response data
        $result = [
            'token' => $token,
            'user' => $user, // You can customize the response data here
        ];
        \Log::info($result);
        return response()->json($result);
    }
}
