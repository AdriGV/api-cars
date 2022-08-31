<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
