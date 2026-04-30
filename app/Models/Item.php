<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'price', 
        'count', 
        'photo_path', 
        'vending_machine_id'
    ];

    public function vendingMachine()
    {
        return $this->belongsTo(VendingMachine::class);
    }
}
