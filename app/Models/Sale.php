<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    public $guarded = [];
    
    public function store(){
        return $this->belongsTo(Store::class);
    }
    
    public function inventories(){
        return $this->hasMany(Inventory::class, 'id'); 
    }
}
