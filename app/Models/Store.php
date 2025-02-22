<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    public $guarded = [];

    public function inventories(){
        return $this->hasMany(Inventory::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }
}
