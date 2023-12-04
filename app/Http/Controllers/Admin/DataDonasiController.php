<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataDonasi;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class DataDonasiController extends Controller
{
    public $data = [
        'parent' => 'Data donasi',
        'modul' => 'data_donasi',
        'position' => 'admin',
    ];
    
    function data_donasi(){
        $this->data['type'] = "index";
        $this->data['data'] = null;
    	return view($this->data['position'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function create(){
        $this->data['type'] = "create";
    	return view($this->data['position'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function update($id_data_donasi){
        $this->data['type'] = "update";
        $query = DataDonasi::where('id_data_donasi', '=', $id_data_donasi)
        ->orderBy('data_donasi.id_data_donasi');
        $query = $query->first();
        $this->data['data'] = $query;
    	return view($this->data['position'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function table(){
        $query = DataDonasi::orderBy('id_data_donasi', 'desc');
        $query = $query->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-2">';
                $btn .= '<a href="'.'/admin/data_donasi/update/'.$row->id_data_donasi.'" class="btn btn-warning btn-raised btn-xs" id="btn-ubah" title="Ubah"><i class="icon-edit"></i></a> &nbsp;';
                $btn .= '<button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus"><i class="icon-trash"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('gambar_donasi', function ($row) {
                $img = '';
                $img .= '<div class="text-center">';
                $img .= '<div class="btn-group btn-group-solid mx-2">';
                $img .= '<a href="' . asset('images/donasi/'.$row->id_data_donasi.'/'.$row->gambar_donasi.'') . '" target="_blank">';
                $img .= '<img src="' . asset('images/donasi/'.$row->id_data_donasi.'/'.$row->gambar_donasi.'') . '" class="mb-3 mt-4" width="100px">';
                $img .= '</a> &nbsp;';
                $img .= '</div>';
                $img .= '</div>';
                return $img;
            })
            ->rawColumns(['action','gambar_donasi'])
            ->make(true);
    }
    
    function createform(Request $request){
        DB::beginTransaction();
        try{
            $cek = DB::table('data_donasi')
            ->select('id_data_donasi')
            ->where('judul_donasi', '=', $request->judul_donasi)
            ->first();
            if($cek == null){
                $dataDonasi = new DataDonasi();
                $dataDonasi->judul_donasi = $request->judul_donasi;
                $dataDonasi->deskripsi_donasi = $request->deskripsi_donasi;
                $dataDonasi->target = $request->target;
                $dataDonasi->save();

                if(isset($request->gambar_donasi)){
                    $filename  = public_path('images/donasi/'. $dataDonasi->id);
                    $file = new Filesystem;
                    $file->cleanDirectory($filename);
                    $imageName = time() . '-donasi.'.$request->gambar_donasi->extension();
                    $request->gambar_donasi->move($filename, $imageName);
             
                    DataDonasi::where('id_data_donasi', $dataDonasi->id)
                    ->update(
                        [
                            'gambar_donasi' => $imageName,
                        ]
                    );
                }
                DB::commit();
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Ditambah!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
            } else{
                DB::rollback();
                return response()->json(['title'=>'Error','icon'=>'error','text'=>'kode sektor sama!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
            }
            
        }catch(\Illuminate\Validation\ValidationException $em){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Email tidak valid!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }
    }

    function updateform(Request $request){
        DB::beginTransaction();
        try{
            $cek = DB::table('data_donasi')
            ->select('id_data_donasi')
            ->where('judul_donasi', '=', $request->judul_donasi)
            ->where('id_data_donasi', '!=', $request->id_data_donasi)
            ->first();
            if($cek == null){
                DataDonasi::where('id_data_donasi', $request->id_data_donasi)
                ->update(
                    [
                        'judul_donasi' => $request->judul_donasi,
                        'deskripsi_donasi' => $request->deskripsi_donasi,   
                        'target' => $request->target,            
                    ]
                );

               
                if(isset($request->gambar_donasi)){
                    $filename  = public_path('images/donasi/'. $request->id_data_donasi);
                    $file = new Filesystem;
                    $file->cleanDirectory($filename);
                    $imageName = time() . '-donasi.'.$request->gambar_donasi->extension();
                    $request->gambar_donasi->move($filename, $imageName);
             
                    DataDonasi::where('id_data_donasi', $request->id_data_donasi)
                    ->update(
                        [
                            'gambar_donasi' => $imageName,
                        ]
                    );
                }

                DB::commit();
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Diubah!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
            } else{
                DB::rollback();
                return response()->json(['title'=>'Error','icon'=>'error','text'=>'Username Sudah Digunakan!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
            }
        }catch(\Illuminate\Validation\ValidationException $em){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Email tidak valid!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }   
    }

    function deleteform(Request $request){

        DB::beginTransaction();
        try{
            $dataDonasi = DataDonasi::where('id_data_donasi', $request->id_data_donasi)->first();
            if ($dataDonasi) {
                // Mendapatkan path lengkap file gambar
                $path = public_path('images/donasi/' . $dataDonasi->id_data_donasi . '/' . $dataDonasi->gambar_donasi);
                
                // Memastikan file gambar ada sebelum menghapus
                if (file_exists($path)) {
                    // Menghapus file gambar
                    unlink($path);
                }
    
                // Menghapus data dari tabel
                DataDonasi::where('id_data_donasi', $request->id_data_donasi)->delete();
            }

            DB::commit();
            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Dihapus!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }   
    }

}