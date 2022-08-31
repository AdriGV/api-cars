<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    public function show()
    {
        $query = DB::table('cars')
        ->join('marcas','cars.marca_id','=','marcas.id')
        ->select('cars.*','marcas.nombre')
        ->where('cars.vendido','=',null)
        ->get();

        return response($query, 200);
    }

    public  function find(Car $car)
    {
        $carid = $car->id;

        $query = DB::table('cars')
        ->join('marcas','cars.marca_id','=','marcas.id')
        ->select('cars.*','marcas.nombre')
        ->where('cars.id','=',$carid)
        ->get();

        return response($query, 200);

    }

    public function create1()
    {
        return view('car.create');
    }
    public function create()
    {
        $attributes = request()->validate([
                'name' => 'required',
                'marca_id' => 'required',
                'marchas' => 'required',
                'combustible' => 'required',
                'color' => 'required',
                'precio' => 'required',
                'imagen' => 'required'
            ]);

            return response(Car::create($attributes),200);
    }

    public function edit(Car $car)
    {
        return view('car.edit', ['car' => $car]);
    }

    public function update(Car $car)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'marca_id' => 'required',
            'marchas' => 'required',
            'combustible' => 'required',
            'color' => 'required',
            'precio' => 'required',
            'imagen' => 'required'
        ]);

        $car->update($attributes);

        return $car;
    }

    public function destroy(Car $car)
    {
        return Car::find($car->id)->delete();

        return redirect('/')->with('success', 'Coche Eliminado');
    }

    public function buy(Car $car)
    {
        $user = auth()->user();

        car::find($car->id)->update(['vendido' => $user->id]);

        return response('vendido',200);
    }
}
