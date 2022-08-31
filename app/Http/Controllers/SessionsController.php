<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class SessionsController extends Controller
{
    public function create()
    {
        return view('register.login');
    }
    public function destroy()
    {
        $user = auth()->user();

        $user->tokens[0]->delete();

        return [
            'message' => 'token destroyed',
        ];
    }

    public function store()
    {

        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $attributes['email'])->first();


        $token = $user->createToken('myapptoken')->plainTextToken;

        $arra = [
            'email' => 'adri@adri.com',
            'password' => '1234567'
        ];

        Log::debug(auth()->attempt($arra));
        if (auth()->attempt($attributes)) {

            return response([
                'user' => $user,
                'message' => 'auth realizada',
                'token' => $token
            ], 202);

        } else {
            Log::debug('Error');

            throw ValidationException::withMessages([
                'email' => 'Email o contraseña equivocada'
            ]);
        }
    }
}
