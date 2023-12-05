<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class UserManagement extends Controller
{
    public $data = [
        "parent" => "User Management",
    ];

    public function index(){
        $this->data['position'] = "Data User";
        $this->data['total_data'] = User::count();
        return view('admin.user_management.index', $this->data);
    }

    public function get_all_data(){
        $data = User::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_user', function($row){
                return $row->is_admin == 1 ? 'Admin' : 'Pengguna Biasa';
            })
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<a class="btn btn-warning ml-1" href="'.env('APP_URL').'/admin/user_management/edit/'.$row->id.'"><i class="fas fa-pencil-alt"></i></a> ';
                $btn .= '<button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus"><i class="icon-trash"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })->make(true);
    }

    public function from_update_user($id){
        $this->data['position'] = "Form Edit User";

        $this->data['data_user'] = User::find($id);
        return view("admin.user_management.index", $this->data);

    }

    public function from_create_user(){
        $this->data['position'] = "Form Create User";

        return view("admin.user_management.index", $this->data);

    }

    public function save_update_user(Request $request, $id){
        $data = User::find($id);
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->is_admin = $request->input('is_admin');

        if ($request->password != "") {
            $data->password = Hash::make($request->password);
        }
        if($data->update()){
            return redirect()->back()->with('status','Updated Successfully');
        } else {
            return redirect()->back()->with('status','Updated Failed');
        }
    }

    public function save_create_user(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'is_admin' => 'required'
        ]);

        $new_user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin
        ]);
        if ($new_user) {
            return redirect()->back()->with('status','User Created Successfully');
        } else {
            return redirect()->back()->with('status','User Created Failed');
        }
    }

    public function delete_user(Request $request){
        DB::beginTransaction();
        try{
            $data_user = User::where('id', $request->id_user)->first();
            if ($data_user) {
                // Menghapus data dari tabel
                User::where('id', $request->id_user)->delete();
                Payment::where('id_user', $request->id_user)->delete();
            }

            DB::commit();
            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Dihapus!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        } 
    }
}
