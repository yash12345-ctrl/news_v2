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
use Illuminate\Validation\Rule;


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
        
        if ($user->status === 0) {
            // Logout the user since attempt() logged them in
            Auth::guard('user-api')->logout();
            throw ValidationException::withMessages([
                "email" => ["Please verify your email using the OTP sent to you before logging in."]
            ]);
        }

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

        if ($user->status === 0) {
            $user->status = 1;
            $user->save();
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
        $rules = [
            'first_name'    => 'required|max:32',
            'last_name'     => 'nullable|max:32',
            'gender'        => 'nullable|integer|in:1,2',
            'dob'           => 'nullable|date',
            'age'           => 'nullable|integer',
            'phone'         => ['nullable', 'numeric', 'digits:10', Rule::unique('users')->whereNull('deleted_at')],
            'email'         => ['required', 'email', 'max:64', Rule::unique('users')->whereNull('deleted_at')],
            'password'      => 'required|min:8|max:30',
            'address_id'    => 'nullable|integer|exists:addresses,id',
        ];

        $existingUser = User::where('email', $request->email)->whereNull('deleted_at')->first();
        if ($existingUser && $existingUser->status === 0) {
            $rules['email'] = ['required', 'email', 'max:64', Rule::unique('users')->ignore($existingUser->id)->whereNull('deleted_at')];
            if ($request->phone && $existingUser->phone === $request->phone) {
                 $rules['phone'] = ['nullable', 'numeric', 'digits:10', Rule::unique('users')->ignore($existingUser->id)->whereNull('deleted_at')];
            }
        }

        $validated = $request->validate($rules);

        $validated['password'] = Hash::make($validated['password'] ?? env('DEFAULT_PASSWORD'));
        $validated['photo'] = env('DEFAULT_IMG');
        $validated['status'] = 0; // 0 = unverified

        if ($existingUser && $existingUser->status === 0) {
            $existingUser->update($validated);
            $user = $existingUser;
        } else {
            $user = User::create($validated);
        }

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

    public function registerPhone(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => 'required|max:32',
            'phone'         => ['required', 'numeric', 'digits:10', Rule::unique('users')->whereNull('deleted_at')],
            'password'      => 'required|min:8|max:30',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['photo'] = env('DEFAULT_IMG');
        
        // Ensure email is null since it's not provided but unique in DB
        $validated['email'] = null;

        $user = User::create($validated);
        $token = $user->createToken('user-token');

        return [
            "user" => new UserResource($user),
            "token" => [
                "token" => $token->plainTextToken,
            ],
        ];
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        Auth::guard('user-api')->logout();
        $user->tokens()->delete();
    }
    public function forgotPasswordSendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->status === 0) {
            throw ValidationException::withMessages([
                'email' => ['Please verify your email first.']
            ]);
        }

        // Delete any existing OTPs for this user
        AuthOtp::where('username', $user->email)->delete();

        // Send email verification code
        $otp = random_int(100000, 999999);
        Mail::to($user)->send(new \App\Mail\ForgotPasswordOtp($user, $otp));

        // Store OTP info in table
        AuthOtp::create([
            'username' => $user->email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes((int) env("OTP_EXPIRE_MINUTES", 15))->toDateTimeString(),
            'created_at' => now()->toDateTimeString(),
        ]);

        return response()->json([
            'message' => 'OTP sent successfully to your email.'
        ]);
    }

    public function forgotPasswordVerifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|size:6',
        ]);

        $otpRecord = AuthOtp::findByUsernameAndOtp($request->email, $request->otp);
        if (is_null($otpRecord)) {
            throw ValidationException::withMessages([
                "otp" => ["Invalid OTP."]
            ]);
        }

        // Has OTP expired?
        $now = new \DateTime();
        $expiry_time = new \DateTime($otpRecord->expires_at);
        if ($now > $expiry_time) {
            $otpRecord->delete();
            throw ValidationException::withMessages([
                "otp" => ["OTP expired."]
            ]);
        }

        return response()->json([
            'message' => 'OTP verified successfully.'
        ]);
    }

    public function forgotPasswordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|size:6',
            'password' => 'required|min:8|max:30|confirmed'
        ]);

        $otpRecord = AuthOtp::findByUsernameAndOtp($request->email, $request->otp);
        if (is_null($otpRecord)) {
            throw ValidationException::withMessages([
                "otp" => ["Invalid OTP."]
            ]);
        }

        // Has OTP expired?
        $now = new \DateTime();
        $expiry_time = new \DateTime($otpRecord->expires_at);
        if ($now > $expiry_time) {
            $otpRecord->delete();
            throw ValidationException::withMessages([
                "otp" => ["OTP expired."]
            ]);
        }

        $user = User::where('email', $otpRecord->username)->first();
        if (is_null($user)) {
            throw ValidationException::withMessages([
                "otp" => ["Invalid OTP."]
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $otpRecord->delete();

        return response()->json([
            'message' => 'Password reset successfully. You can now log in.'
        ]);
    }
}
