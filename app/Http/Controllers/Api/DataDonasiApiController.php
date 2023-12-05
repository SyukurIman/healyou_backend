<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Donasi;
use App\Models\DataDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DataDonasiApiController extends Controller
{
    public function get_data_donasi(Request $request)
        {
            $dataDonasi = DataDonasi::get();

            if ($dataDonasi->isNotEmpty()) {
                $baseUrl = env('APP_URL'); 

                $dataDonasi = $dataDonasi->map(function ($donasi) use ($baseUrl) {
                    $donasi['gambar_path'] = $baseUrl . '/images/donasi/'.$donasi->id_data_donasi.'/'. $donasi->gambar_donasi;
                    return $donasi;
                });

                return response()->json([
                    'success'     => true,
                    'dataDonasi'  => $dataDonasi,
                ], 201);
            }

            // return JSON process insert failed 
            return response()->json([
                'success' => false,
            ], 409);
        }

        public function get_detail_data_donasi(Request $request)
        {
            $id_data_donasi = $request->input('id_data_donasi');

            $dataDonasi = DataDonasi::where('id_data_donasi', $id_data_donasi)
                ->first();

            // return response JSON data donasi ditemukan
            if ($dataDonasi) {
                $baseUrl = env('APP_URL'); 

                $dataDonasi['gambar_path'] = $baseUrl . '/images/donasi/' . $dataDonasi->id_data_donasi . '/' . $dataDonasi->gambar_donasi;

                return response()->json([
                    'success'     => true,
                    'dataDonasi'  => $dataDonasi,
                ], 200);
            }

            // return JSON data donasi tidak ditemukan 
            return response()->json([
                'success' => false,
                'message' => 'Data donasi not found',
            ], 404);
        }


}
