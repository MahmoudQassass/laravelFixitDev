<?php

namespace App\Http\Controllers\APIControllers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Database\Factories\UserFactory;
use Illuminate\Http\Request;
use App\Traits\AuthApiResponser;
use App\Http\Requests\FixitRegisterAPIRequest;
use App\Http\Requests\FixitLoginAPIRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class fixitAPIAuthController extends Controller
{
    use AuthApiResponser;

    public function register(FixitRegisterAPIRequest $request)
    {
        $user = new CreateNewUser();
        $newUser=  $user->create($request->only(  'name',
            'password',
            'email','password_confirmation'));
        return new UserResource($newUser);
//        $user = User::create([
//            'name' => $request->name,
//            'password' => bcrypt($request->password),
//            'email' => $request->email
//        ])

    }

    public function login(FixitLoginAPIRequest $request)
    {
        if (!Auth::attempt($request->only('email','password'))) {
            return $this->error('The given data was invalid.', 401,['The selected password is invalid.']);
        }
        return   (new UserResource($request->user()))->additional([
        'meta'=>['token' => $request->user()->createToken('API Token')->plainTextToken]
    ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(
            [
                'message'=>'logout success'
            ],200
        );
    }
}
