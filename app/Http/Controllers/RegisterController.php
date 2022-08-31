<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store()
    {
       $attributes = request()->validate([
            'name'=>'required|max:255|min:3',
            'email'=>'required|email|max:255',
            'password'=>'required|min:7|max:255'
        ]);

        $user = User::create([
        'name'=>$attributes['name'],
        'email'=>$attributes['email'],
        'password'=>bcrypt($attributes['password'])]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        auth()->login($user);

        $data=['user'=>$user,
                'token'=>$token];

        return response($data,201);
    }
}
