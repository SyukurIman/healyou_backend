<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\DataDonasi;
use App\Models\Donasi;
use App\Services\Midtrans\CreateSnapTokenService; // => put it at the top of the class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{

    public function get_data_all()
    {
        $data_payment = Payment::where('id_user', Auth::user()->id)->with('data_donasi')->get();

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
            'price'             => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (DataDonasi::where('id_data_donasi', $request->id_donasi)->first()) {
            $data = [
                'id_donasi'         => $request->id_donasi,
                'id_user'           => Auth::user()->id,
                'price'             => $request->price,
                'payment_status'    => 1
            ];

            $data['dukungan'] =  ($request->dukungan != '' ?  $request->dukungan : '');
            $data['nama_donatur'] = ($request->nama_donatur != '' ? $request->nama_donatur : 'Donatur Rahasia');
            
            $payment = Payment::create($data);
    
            if($payment){
                $midtrans = new CreateSnapTokenService($payment);
                $snapToken = $midtrans->getSnapToken();
    
                $payment->snap_token = $snapToken;
                $payment->save();
    
                return response()->json([
                    'success' => true,
                    'token_snap_midtrans'  => $snapToken,
                    'dukungan' => $request->dukungan,
                    'nama_donatur' => $data['nama_donatur']
                ], 201);
    
            }
        }
        
        //return JSON process insert failed 
        return response()->json([
            'success' => false,
            'msg' => "Data Donasi Tidak Ditemukan" 
        ], 409);
    }

    public function get_data(Request $request){
        $validator = Validator::make($request->all(), [
            'id_payment'        => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data_payment = Payment::where('id', $request->id_payment)->with('data_donasi')->first();
        if ($data_payment){
            return response()->json([
                'success' => true,
                'data_payment' => $data_payment,
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

        $data_payment = Payment::where('id_donasi', $request->id_donasi)->where('payment_status', '2')->get();

        $total_price_now = 0;
        foreach ($data_payment as $key => $d_p) {
            $total_price_now += $d_p->price;
        }
        if ($data_payment){
            return response()->json([
                'success' => true,
                'total_terkumpul' => $total_price_now,
                'data_payment' => $data_payment,
                
            ]);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }
    
}
