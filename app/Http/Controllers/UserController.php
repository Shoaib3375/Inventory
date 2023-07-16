<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller {
    function UserRegistration(Request $request) {
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName'  => $request->input('lastName'),
                'email'     => $request->input('email'),
                'mobile'    => $request->input('mobile'),
                'password'  => $request->input('email'),
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'User Registration Successfully',
            ], 200);
        } catch (Throwable $e) {
            // return report($e);
            return response()->json([
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ], 200);
        }

    }
}