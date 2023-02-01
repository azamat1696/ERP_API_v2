<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\Auth\AuthUpdateRequest;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
 

class AuthController extends Controller
{
    
    public function register(AuthRequest $request): \Illuminate\Http\JsonResponse
    {
        $user =  User::create($request->only('name','surname','email') + ['password' => Hash::make($request->password)]);
        return response()->json($user);
    }
    public function index(){
        $users = User::all();
        return response()->json($users);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(AuthUpdateRequest  $request, $id){
        $item = User::findOrFail($id);
        
        if($item->email == env('ADMIN_EMAIL'))
        {
                  return response()->json([
           'message' => 'Invalid login details',
           'status' => 400,
           'payload' => [
               'errors' => [
                   'Sistem "Süper" Kullanıcı Değiştirilemez...'
               ]
           ]
          ], 400);
        }
         if(Hash::check($request->validated()['oldPassword'],$item->password)){
            $item->update([ 'password' => Hash::make($request->validated()['password'])]);
            return response()->json($item);
          }
         return response()->json([
           'message' => 'Invalid login details',
           'status' => 400,
           'payload' => [
               'errors' => [
                   'Yalnış şifre girdiniz'
               ]
           ]
          ], 400);
    }

    public  function login( Request $request) {
   
        // auth()->user()->tokens()->delete();
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details',
                'status' => 401,
                'errors' => $validator->errors(),
               
            ], 401);
        }
        $user = User::where('email', $validator->validated()['email'])->firstOrFail();

       
       Auth::user()->tokens->each(function($token, $key) {
        $token->delete();
       });
       
    $token = $user->createToken('auth_token')->plainTextToken;
        //Token created, return with success response and   token
        return response()->json([
            'success' => true,
            'token' => $token,
            'userDetail' => auth()->user(),
            'expiresIn' => env('JWT_TTL')
        ]);
    }
}
