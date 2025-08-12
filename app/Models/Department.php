<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //campos que podem ser preenchidos em massa
    protected $fillable = ['name']; 

    public function items()
    {
        //um departamento tem muitos itens
        return $this->hasMany(Item::class); 
    }
}