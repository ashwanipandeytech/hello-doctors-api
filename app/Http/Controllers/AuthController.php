<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Traits\httpResponses;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;


class AuthController extends Controller
{
    use httpResponses;

    public function login(Request $request){
        $request->validate([
            'data.email' => 'required|email',
            'data.password' => 'required',
        ]);
        $username = $request->input('data.email');
        $password = $request->input('data.password');

        if(!Auth::attempt(['email' => $username, 'password' => $password])){
            return $this->error('','Credentials do not match',401);
        }

        $user = User::where('email',$username)->first();
        $user->token = $user->createToken('ApiToken')->plainTextToken;
        return $this->success($user,'',200);

    }

    public function register(Request $request){
      // $request->validated($request->all());
        $request->validate([
            'data.name' => 'required|string',
            'data.email' => 'required|email|unique:users,email',
            'data.password' => 'required|min:6',
            'data.mobileNo' => 'required|min:10',
        ]);
       $user = User::create([
         'name' => $request->input('data.name'),
         'email' => $request->input('data.email'),
         'password' => Hash::make($request->input('data.password')),
         'phone' => $request->input('data.mobileNo'),
         'userType' => $request->input('data.userType'),
       ]);
        $user->token = $user->createToken('ApiToken')->plainTextToken;
        return $this->success($user,'Registration successful',200);
     
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
    }

    public function moveGuestCartToUser($userId,$token)
    {      
        Cart::where('token', $token)->update(['user_id' => $userId, 'token' => null]);
        return response()->json(['message' => 'Guest cart items moved to the user']);
    }


}
