<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\RestController;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Validation\Auth\AuthValidation;
use Carbon\Carbon;

use App\Http\Models\Admin\Users;

class AuthController extends RestController {

    use AuthValidation;
    
    public function login(Request $request) : Response {
        $validator = $this->validLogin($request);

        if ($validator->fails()) {
            return $this->error(405, 'Validation error', $validator->errors()->toArray());
        }

        $hasLogged = Auth::once(['email' => mb_strtolower($request->email, 'UTF-8'), 'password' => $request->password]);

        if (!$hasLogged) {
            return $this->error(401, 'Unauthorized');
        }

        $user = Auth::user();
        $tokenResult = $user->createToken($user->email);
        $token = $tokenResult->token;
        if ($request->remember_me) $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return $this->success([
            'email' => $user->email,
            'image' => $user->image,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',

            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    
    public function user() { 
        $user = Auth::user(); 
        return $this->success([
            'user' => $user
        ]); 
    } 
    
    public function userExist(Request $request): Response {
        $result = Users::userExist($request->email);
        return $this->success([
            'exist' => $result
        ]); 
    }

}
