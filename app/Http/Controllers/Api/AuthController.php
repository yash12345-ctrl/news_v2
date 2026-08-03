<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\AuthOtp;
use App\Mail\UserRegistered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;


class AuthController extends Controller
{

    public function index()
    {
        return view('index');
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required", "max:32"],
        ]);

        if (Auth::guard('user-api')->attempt($credentials) === false) {
            throw ValidationException::withMessages([
                "email" => ["Invalid email or password."]
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('user-token');

        return [
            "user" => $user,
            "token" => [
                "token" => $token->plainTextToken,
            ],
        ];
    }

    public function authenticateViaEmailOTP(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "otp" => ["required", "size:6"],
        ]);

        $otp = AuthOtp::findByUsernameAndOtp($credentials["email"], $credentials["otp"]);
        if (is_null($otp)) {
            throw ValidationException::withMessages([
                "otp" => ["Invalid OTP."]
            ]);
        }

        // Has OTP expired?
        $now = new \DateTime();
        $expiry_time = new \DateTime($otp->expires_at);
        if ($now > $expiry_time) {
            $otp->delete();
            throw ValidationException::withMessages([
                "otp" => ["OTP expired."]
            ]);
        }

        $user = User::where('email', $otp->username)->first();
        if (is_null($user)) {
            throw ValidationException::withMessages([
                "otp" => ["Invalid OTP."]
            ]);
        }

        $token = $user->createToken('user-token');
        $otp->delete();

        return [
            "user" => $user,
            "token" => [
                "token" => $token->plainTextToken,
            ],
        ];
    }

    public function register(Request $request): JsonResource
    {
        $validated = $request->validate([
            'first_name'    => 'required|max:32',
            'last_name'     => 'nullable|max:32',
            'gender'        => 'nullable|integer|in:1,2',
            'dob'           => 'nullable|date',
            'age'           => 'nullable|integer',
            'phone'         => 'required|numeric|digits:10|unique:users',
            'email'         => 'required|email|unique:users|max:64',
            'password'      => 'nullable|min:8|max:30',
            'address_id'    => 'nullable|integer|exists:addresses,id',
        ]);

        $validated['password'] = Hash::make($validated['password'] ?? env('DEFAULT_PASSWORD'));
        $validated['photo'] = env('DEFAULT_IMG');

        $user = User::create($validated);

        // Send email verification code
        $otp = random_int(100000, 999999);
        $account = ['email_verification_code' => $otp];
        Mail::to($user)->send(new UserRegistered($user, $account));

        // Store OTP info in table
        $auth_otp = AuthOtp::create([
            'username' => $user->email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes((int) env("OTP_EXPIRE_MINUTES", 15))->toDateTimeString(),
            'created_at' => now()->toDateTimeString(),
        ]);

        return new UserResource($user);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        Auth::guard('user-api')->logout();
        $user->tokens()->delete();
    }
}
