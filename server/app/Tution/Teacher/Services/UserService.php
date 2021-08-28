<?php

namespace App\Tution\Teacher\Services;

use Illuminate\Http\Request;

interface UserService
{
    public function register(Request $request);

    public function login(Request $request);

    public function verify(Request $request);

    public function passwordVerify(Request $request);

    public function getProfile(Request $request);

    public function updateProfileImage(Request $request);

    public function updateProfile(Request $request);

    public function verifyOTP(string $key, string $code);
}
