<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'auth_code',
        'image',
        'phone',
        'role_id',
        'status',
        'auth_created',
        'created_by',
        'last_login',
        'activated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($admin) {
            $google2FA = new Google2FA();
            $uniqueSecret = false;
            $code = $google2FA->generateSecretKey();

            do {
                if (Admin::where('auth_code', $code)->count() > 0) {
                    $code = $google2FA->generateSecretKey();
                } else {
                    $uniqueSecret = true;
                }
            } while ($uniqueSecret === false);

            $admin->auth_code = $code;
            $admin->auth_created = gmdate('Y-m-d H:i:s');
            $admin->save();

            $admin->notify(new EmailConfirmNotification(bcrypt($admin->id . $admin->auth_code), $admin->email));
        });
    }

    public function isOTPValid($otp)
    {
        // initialize Google 2 factor authentication lib
        $google2Fa = new Google2FA();
        return $google2Fa->verifyKey($this->auth_code, $otp);
    }

    public function getIdentifier()
    {
        $identifier = '';

        do {
            $identifier = Str::random(247) . date("Ymd");
        } while (AdminSession::where('identifier', $identifier)->count() !== 0);

        return $identifier;
    }
}
