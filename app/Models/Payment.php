<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'id_donasi',
        'id_user',
        'price',
        'payment_status',
        'snap_token',
        'dukungan',
        'nama_donatur'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'id_user' , 'id');
    }

    public function data_donasi(){
        return $this->belongsTo(DataDonasi::class, 'id_donasi' , 'id_data_donasi');
    }
}
