<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Donasi;
use App\Services\Midtrans\CreateSnapTokenService; // => put it at the top of the class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{

    public function get_data_all()
    {
        $data_payment = Payment::where('id_user', Auth::user()->id)->get();

        if($data_payment){
            return response()->json([
                'success' => true,
                'data_payment' => $data_payment
            ]);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function show_example_test($id)
    {
        $payment = Payment::find($id);
        $snapToken = $payment->snap_token;
         if (is_null($snapToken)) {
            $midtrans = new CreateSnapTokenService($payment);
            $snapToken = $midtrans->getSnapToken();

            $payment->snap_token = $snapToken;
            $payment->save();
         }

         return view('example_payment.show', compact('payment', 'snapToken'));
    }

    public function create_payment(Request $request){
        $validator = Validator::make($request->all(), [
            'id_donasi'         => 'required',
            'price'             => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $payment = Payment::create([
            'id_donasi'         => $request->id_donasi,
            'id_user'           => Auth::user()->id,
            'price'             => $request->price,
            'payment_status'    => 1
        ]);

        if($payment){
            $midtrans = new CreateSnapTokenService($payment);
            $snapToken = $midtrans->getSnapToken();

            $payment->snap_token = $snapToken;
            $payment->save();

            return response()->json([
                'success' => true,
                'token_snap_midtrans'  => $snapToken,
            ], 201);

        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function get_data(Request $request){
        $validator = Validator::make($request->all(), [
            'id_payment'        => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data_payment = Payment::find($request->id_payment);
        if ($data_payment){
            return response()->json([
                'success' => true,
                'data_payment' => $data_payment
            ]);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function get_data_id_donasi(Request $request){
        $validator = Validator::make($request->all(), [
            'id_donasi'        => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data_payment = Payment::where('id_donasi', $request->id_donasi)->get();
        if ($data_payment){
            return response()->json([
                'success' => true,
                'data_payment' => $data_payment
            ]);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }
    
}
