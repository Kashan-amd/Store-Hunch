<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    public $guarded = [];

    public function store(){
        return $this->belongsTo(Store::class);
    }
    
    public function sale(){
        return $this->belongsTo(Sale::class, 'sale_id'); 
    }
}
