<?php

namespace App\Services\Midtrans;

use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $payment;

    public function __construct($payment)
    {
        parent::__construct();

        $this->payment = $payment;
    }

    public function getSnapToken()
    {
        // $donasi = Payment::where('id_donasi', $request->id_donasi)->first();
        $params = [
            'transaction_details' => [
                'order_id' => 'healyou_'.$this->payment->id,
                'gross_amount' => $this->payment->price,
                
            ],
            'item_details' => [
                [
                    'id_donasi' => 1,
                    'price' => $this->payment->price,
                    'name' => 'Flashdisk Toshiba 32GB',
                    'quantity' => 1
                ]
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}