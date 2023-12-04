<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDonasi extends Model
{
    use HasFactory;

    protected $table = 'data_donasi';
    
    protected $fillable = [
        'judul_donasi',
        'deskripsi_donasi',
        'target',
        'gambar_donasi'
    ];
}