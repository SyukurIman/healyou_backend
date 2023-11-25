<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DonasiController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'metode_pembayaran'    => 'required',
            'nominal'              => 'required',
            'dukungan'             => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create donation
        $donasi = Donasi::create([
            'id_user'            => Auth::user()->id,
            'metode_pembayaran'  => $request->metode_pembayaran,
            'nominal' => filter_var($request->nominal, FILTER_SANITIZE_NUMBER_FLOAT),
            'dukungan'           => $request->dukungan,
        ]);

        //return response JSON donation is created
        if ($donasi) {
            return response()->json([
                'success' => true,
                'donasi'  => $donasi,
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function history(Request $request)
    {
        // Implementasi riwayat donasi
    }
}
