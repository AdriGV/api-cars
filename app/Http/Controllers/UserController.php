<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function perfil()
    {
        $user = auth()->user();


        return response([
            'user' => $user
        ], 200);
    }

    public function edit(User $user)
    {
        return view('perfil.edit', ['user' => $user]);
    }


    public function update(User $user)
    {
        $attributes = request()->validate([
            'name' => 'required|max:255|min:3',
            'email' => 'required|email|max:255',
            'password' => 'required|min:7|max:255'
        ]);


        $user->update($attributes);

        return response(['user' => $user], 200);
    }

    public function destroy(User $user)
    {

        user::find($user->id)->delete();
        $user->tokens()->delete();

        return response([
            'message' => 'usuario eliminado',
        ], 200);
    }

    public function show()
    {


        return response(['users' => DB::table('users')->get()], 200);
    }

    public function validarmail()
    {

        $mail = request()->input('email');
        $valido = true;

        if (User::where('email', '=', $mail)->exists()) {
            $valido = false;
            $message = 'Ya existe este email';
        } else {
            $valido = true;
            $message = '';
        }

        return response([
            'valido' => $valido,
            'mensaje' => $message,
        ], 200);
    }
}
