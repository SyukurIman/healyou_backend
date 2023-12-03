<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\Midtrans\CallbackService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        $callback = new CallbackService;
 
        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $Payment = $callback->getOrder();

            // $orderNumber = $Payment->order_id;
            // $id_payment = explode("_",$orderNumber)[1];
 
            if ($callback->isSuccess()) {
                Payment::where('id', $Payment->id)->update([
                    'payment_status' => 2,
                ]);
            }
 
            if ($callback->isExpire()) {
                Payment::where('id', $Payment->id)->update([
                    'payment_status' => 3,
                ]);
            }
 
            if ($callback->isCancelled()) {
                Payment::where('id', $Payment->id)->update([
                    'payment_status' => 4,
                ]);
            }
 
            return response()
                ->json([
                    'success' => true,
                    'message' => $Payment->id,
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}
