<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthOtp extends Model
{
    use HasFactory;

    protected $table = "auth_otps";

    public $timestamps = false;

    protected $fillable = ['username', 'otp', 'expires_at', 'created_at'];

    public static function findByUsernameAndOtp(string $username, string $otp)
    {
        return $otp = self::where('username', $username)->where('otp', $otp)->first();
    }
}
