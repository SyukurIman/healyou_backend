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
        'snap_token'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'id_user' , 'id');
    }
}
