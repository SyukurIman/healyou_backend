<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $table = 'donasi';
    
    protected $fillable = [
        'id_user',
        'nominal',
        'dukungan',
        'metode_pembayaran',
    ];
}
