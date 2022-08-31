<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{
    public function create()
    {
        return view('marca.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'nombre' => 'required|max:255|min:3',
        ]);


        Marca::create($attributes);

        return redirect('/')->with('success', 'Your marca has been created');
    }

    public function showAll(){
        return response(['marcas' => DB::table('marcas')->get()], 200);
    }
}
