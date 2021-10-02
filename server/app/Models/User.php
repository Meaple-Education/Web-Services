<?php

namespace App\Models;

use Str;

use App\Notifications\Teacher\EmailConfirmNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PragmaRX\Google2FA\Google2FA;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';

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
        'status',
        'auth_created',
        'created_by',
        'last_login',
        'email_verified',
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
        static::created(function ($user) {
            $google2FA = new Google2FA();
            $uniqueSecret = false;
            $code = $google2FA->generateSecretKey();

            do {
                if (User::where('auth_code', $code)->count() > 0) {
                    $code = $google2FA->generateSecretKey();
                } else {
                    $uniqueSecret = true;
                }
            } while ($uniqueSecret === false);

            $user->auth_code = $code;
            $user->auth_created = gmdate('Y-m-d H:i:s');
            $user->save();

            $user->notify(new EmailConfirmNotification(bcrypt($user->id . $user->auth_code), $user->email));
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
        } while (UserSession::where('identifier', $identifier)->count() !== 0);

        return $identifier;
    }
}
