<?php

namespace App\Http\Controllers;
use App\Troli;
use App\TroliDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TroliController extends Controller
{
    public function index($id){
        $trolis = Troli::where('id',$id)->first();
        $troli_details = TroliDetail::where('troli_id',$id)->get();
        
        if($trolis->tipe_discount == 'fixed'){
            $discTipe = '';
            $discTotal = $trolis->discount;
            $discTotalView = $trolis->discount;
        }
        if($trolis->tipe_discount == 'percent'){
            $discTipe = '('.$trolis->discount.'%)';
            $discTotal = $trolis->subtotal* ($trolis->discount/100);
            $discTotalView = 'Rp -'.number_format($discTotal);
        }
        else{
            $discTipe = '';
            $discTotal = '';
            $discTotalView = '';
        }
        
        return view('troli',compact('trolis','troli_details','discTipe','discTotalView'));
    }

    public function qtychange(Request $request, $id){
        $troli_details = TroliDetail::where('id',$id)->first();
        
        if($request->tipe == 'up'){
            $troli_details->qty = $troli_details->qty+$request->qty;
            $troli_details->subtotal = ($troli_details->qty)*$troli_details->harga;
            $troli_details->update();
        }else{
            $troli_details->qty = $troli_details->qty-$request->qty;
            if($troli_details->qty <= 0){
                // Alert
                alert()->info('Kuantitas Tidak Boleh 0', 'info');
            }else{
            $troli_details->subtotal = ($troli_details->qty)*$troli_details->harga;
            $troli_details->update();
            }
        }

        // Sum Troli
        $troliSum = TroliDetail::where('troli_id',$troli_details->troli_id)->sum('subtotal');
        $trolis = Troli::where('id',$troli_details->troli_id)->first();
        $trolis->subtotal = $troliSum;
        // perhitungan jika terdapat Discount
        if($trolis->tipe_discount == 'fixed'){
            if($trolis->kupon_kode == 'FA333'){
                $disc = TroliDetail::where('harga', '>', 400000)->sum('subtotal');
                $trolis->discount = $disc*(6/100);
                $trolis->total = $trolis->subtotal - $trolis->discount;
            }
            else{
                $trolis->total = $troliSum-($trolis->discount);
            }
        }
        elseif($trolis->tipe_discount == 'percent'){
            $trolis->total = $troliSum-($troliSum * ($trolis->discount/100));
        }else{
            $trolis->total = $troliSum;    
        }
        $trolis->update();


        // Cek Kode Kupon
       
        return redirect('/'.$troli_details->troli_id);
    }

    public function delete(Request $request, $id){
        $troli_details = TroliDetail::findOrFail($id);
        $troli_details->delete();

        $troliSum = TroliDetail::where('troli_id',$troli_details->troli_id)->sum('subtotal');
        $trolis = Troli::where('id',$troli_details->troli_id)->first();
        $trolis->subtotal = $troliSum;
        // perhitungan jika terdapat discount
        if($trolis->tipe_discount == 'fixed'){
            if($trolis->kupon_kode == 'FA333'){
                $disc = TroliDetail::where('harga', '>', 400000)->sum('subtotal');
                $trolis->discount = $disc*(6/100);
                $trolis->total = $trolis->subtotal - $trolis->discount;
            }
            else{
                $trolis->total = $troliSum-($trolis->discount);
            }
        }
        elseif($trolis->tipe_discount == 'percent'){
            $trolis->total = $troliSum-($troliSum * ($trolis->discount/100));
        }else{
            $trolis->total = $troliSum;    
        }
        $trolis->update();
        // Alert
        alert()->success('Data berhasil dihapus', '');
        return redirect('/'.$troli_details->troli_id);
    }
}