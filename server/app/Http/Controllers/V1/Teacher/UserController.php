<?php

namespace App\Http\Controllers\V1\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Teacher\Auth\LoginRequest;
use App\Http\Requests\V1\Teacher\Auth\RegisterRequest;
use App\Http\Requests\V1\Teacher\Auth\VerifyPasswordRequest;
use App\Http\Requests\V1\Teacher\Auth\VerifyRequest;
use App\Tution\Teacher\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterRequest $request)
    {
        $register = $this->service->register($request);
        return response()->json($register, $register['code']);
    }

    public function login(LoginRequest $request)
    {
        $login = $this->service->login($request);
        return response()->json($login, $login['code']);
    }

    public function passwordVerify(VerifyPasswordRequest $request)
    {
        $passwordVerify = $this->service->passwordVerify($request);
        return response()->json($passwordVerify, $passwordVerify['code']);
    }

    public function uploadProfileImage(Request $request)
    {
    }

    public function updateProfile(Request $request)
    {
    }

    public function getProfile(Request $request)
    {
        $profile = $this->service->getProfile($request);
        return response()->json($profile, $profile['code']);
    }

    public function verifyAccount(VerifyRequest $request)
    {
        $verifyAccount = $this->service->verify($request);
        return response()->json($verifyAccount, $verifyAccount['code']);
    }
}
