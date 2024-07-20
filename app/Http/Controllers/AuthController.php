<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $validated['role']=RoleType::USER;

        $user = User::create($validated);

        return $this->successResponse(new UserResource($user),'User Created',201);
    }

    public function login(UserLoginRequest $request): JsonResponse{
        $validate = $request->validated();

        if(!auth()->attempt($validate)){
            return $this->errorResponse('Unauthorized',401);
        }

        $user = User::where('email',$validate['email'])->firstOrFail();
        //if token exists
        if($user->tokens()->count() > 0){
            $user->tokens()->delete();
        }
        $user['token'] = $user->createToken('token')->plainTextToken;
        $user['token_type'] = 'Bearer';

        return $this->successResponse(new LoginResource($user),'Successfully Login',200);
    }
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return $this->successWithoutData('Successfully Logout',200);
    }

    public function me(): JsonResponse
    {
        return $this->successResponse(new UserResource(auth()->user()),'Successfully Fetch User Data',200);
    }
}
