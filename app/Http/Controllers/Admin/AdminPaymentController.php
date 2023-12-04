<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminPaymentController extends Controller
{
    public $data = [
        "parent" => "Payment",
    ];

    public function index(){
        $this->data['position'] = "Payment History";

        $this->data['payment_history'] = Payment::orderBy('updated_at', 'DESC')->count();
        return view("admin.payment.index", $this->data);
    }

    public function get_all_data(){
        $data = Payment::orderBy('updated_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('date', function($row){
                return Carbon::parse($row->created_at)->format('m/d/Y H:i:s');
            })
            ->addColumn('nominal_rp', function($row){
                return "Rp. ".number_format($row->price, 2);
            })
            ->addColumn('status_pembayaran', function($row){
                return ($row->payment_status == 1 ? 'Pembayaran Berhasil' : $row->payment_status == 2 ) ? 'Menunggu Pembayaran'  : 'Pembayaran Expired';
            })
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<a class="btn btn-warning ml-1" href="'.env('APP_URL').'/admin/payment/history/edit/'.$row->id.'"><i class="fas fa-pencil-alt"></i></a> ';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })->make(true);
    }

    public function from_update_status($id){
        $this->data['position'] = "Form Edit Payment";

        $this->data['data_payment'] = Payment::find($id);
        return view("admin.payment.index", $this->data);

    }

    public function save_update_status(Request $request, $id){
        $data = Payment::find($id);
        $data->payment_status = $request->input('payment_status');
        if($data->update()){
            return redirect()->back()->with('status','Updated Successfully');
        } else {
            return redirect()->back()->with('status','Updated Failed');
        }
    }
}
