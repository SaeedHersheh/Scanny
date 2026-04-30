<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class VendingMachine extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'admin_id',
        'qr_code_url',
    ];




    public function items()
{
    return $this->hasMany(Item::class);
}

}
