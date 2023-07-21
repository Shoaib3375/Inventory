<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller {
    function UserRegistration(Request $request) {
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName'  => $request->input('lastName'),
                'email'     => $request->input('email'),
                'mobile'    => $request->input('mobile'),
                'password'  => $request->input('password'),
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'User Registration Successfully',
            ], 200);
        } catch (Exception $e) {
            // return report($e);
            return response()->json([
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ], 200);
        }

    }
    function UserLogin(Request $request) {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->count();

        if ($count == 1) {
            // User login -> JWT Token issue
            $token = JWTToken::createToken($request->input('email'));
            return response()->json([
                'status'  => 'Success',
                'message' => 'User Login Successfull',
                'token'   => $token,
            ], 200);
        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'UnAuthorized',
            ], 401);
        }
    }

    function SentOTPCode(Request $request) {
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();

        if ($count == 1) {
            // OTP email addr
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', '=', $email)->update(['otp' => $otp]);
            return response()->json([
                'status'  => 'Success',
                'message' => 'Otp send your mail',
            ], 250);
            // otp code table insert
        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Unuthorized',
            ], 401);
        }
    }
}