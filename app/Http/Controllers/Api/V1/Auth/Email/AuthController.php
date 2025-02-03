<?php

namespace App\Http\Controllers\Api\V1\Auth\Email;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Http\Requests\Api\V1\Auth\Email\RegisterRequest;
use App\Http\Requests\Api\V1\Auth\Email\LoginRequest;
use App\Http\Requests\Api\V1\Auth\Email\ForgotPasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Constants\EmailAuthConstants;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\Api\V1\Auth\Email\ResetPasswordRequest;

class AuthController extends ApiController
{
    public function register(RegisterRequest $request){

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('UserToken')->plainTextToken; // Created token by token_name = "UserToken"

        event(new Registered($user));

        return $this->successResponse( $success, 'Some issue');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            // $user->tokens()->delete();
            $success['token'] = $user->createToken('UserToken')->plainTextToken;
            return $this->successResponse($success, EmailAuthConstants::LOGIN );
        }
        else{
            return $this->respondWithUnauthorized(message: EmailAuthConstants::VALIDATION);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return $this->successResponse( message: EmailAuthConstants::LOGOUT );
    }

    public function verify_email(Request $request)
    {
        $user = User::findorFail($request->id);
      
        if ($user)
        {
             // check if user had already verified
             if ($user->hasVerifiedEmail()) { return $this->successResponse(message:EmailAuthConstants::EMAIL_ALREADY_VERIFIED,statusCode:Response::HTTP_OK);}
             
             // marking user email as verified
             elseif ($user->markEmailAsVerified())
             {
                 // event(new Verified($this->user()));
                 return $this->successResponse(message:EmailAuthConstants::EMAIL_VERIFICATION_SUCCESS,statusCode:Response::HTTP_OK);
             }
         }
         return $this->errorResponse(message:EmailAuthConstants::EMAIL_VERIFICATION_INVALID_ID,statusCode:Response::HTTP_NOT_FOUND);
    }

    public function reset_password(ResetPasswordRequest $request)
    {
        $response = Password::reset(
            $request->only('email','token','password','password_confirmation'),
                function (User $user, string $password)
                {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ]);
                    $user->save();

                    // event(new PasswordReset($user));
                }
        );

        switch ($response) {
            case Password::INVALID_TOKEN:
                return $this->errorResponse( message: EmailAuthConstants::PASSWORD_RESET_INVALID_TOKEN, statusCode: 400);

            case Password::PASSWORD_RESET:
                return $this->successResponse( message: EmailAuthConstants::PASSWORD_RESET_SUCCESS);

            default:
                return $this->errorResponse( message: EmailAuthConstants::PASSWORD_RESET_FAILED );
        }
    }

    public function forgot_password(ForgotPasswordRequest $request)
    {
        $response = Password::sendResetLink( $request->only('email'));

        switch($response){
            case Password::RESET_THROTTLED:
                return $this->errorResponse( message: EmailAuthConstants::PASSWORD_RESET_LINK_TROTTLED, statusCode: 429);

            case Password::RESET_LINK_SENT:
                return $this->successResponse( message: EmailAuthConstants::PASSWORD_RESET_LINK_SENT );

            default:
                return $this->errorResponse( message: EmailAuthConstants::PASSWORD_RESET_LINK_FAILED);
        }
    }

    public function resend_verify_email(){
        // 
        $user = Auth::user();
        if ($user)
        {
            // check if user had already verified
            if ($user->hasVerifiedEmail()) { return $this->successResponse(message:EmailAuthConstants::EMAIL_ALREADY_VERIFIED,statusCode:Response::HTTP_OK);}
            
            // Resend the verification email
            $user->sendEmailVerificationNotification();

            return $this->successResponse(message:EmailAuthConstants::EMAIL_VERIFICATION_SENT, statusCode:Response::HTTP_OK);
        }
        return $this->errorResponse(message:EmailAuthConstants::EMAIL_VERIFICATION_INVALID_ID,statusCode:Response::HTTP_NOT_FOUND);
    }
}
