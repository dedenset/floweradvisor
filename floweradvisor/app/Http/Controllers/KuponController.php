<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Troli;
use App\TroliDetail;
use Carbon\Carbon;

class KuponController extends Controller
{
    public function kupon(Request $request, $id){
        /*
        Input discount code, terdapat 3 macam tipe discount:
        1.	Discount code: FA111 akan memberikan diskon 10%
        2.	Discount code: FA222 akan memberikan diskon 50rb untuk barang dengan kode FA4532
        3.	Discount code: FA333 akan memberikan diskon 6% untuk barang diatas 400 ribu
        4.	Discount code: FA444 akan memberikan diskon 5% jika pelanggan membeli di hari selasa jam 13:00 s/d 15:00
        */

        if(empty($request->kodekupon)){
            alert()->warning('Kupon yang anda masukan kosong', 'info');
        }
        elseif($request->kodekupon == 'FA111'){ 
            //1. Discount code: FA111 akan memberikan diskon 10%
            $troli = Troli::where('id',$id)->first();
            $troli->tipe_discount = 'percent';
            $troli->discount = '10';
            $troli->total = $troli->subtotal - ($troli->subtotal*($troli->discount/100));
            $troli->kupon_kode = $request->kodekupon;
            $troli->update();
            alert()->success('Kupon berhasil dimasukan', 'info');
        }
        elseif($request->kodekupon == 'FA222'){ 
            //2.	Discount code: FA222 akan memberikan diskon 50rb untuk barang dengan kode FA4532
            $troli_detail = TroliDetail::where('produk_kode', 'FA4532')->first();
            //dd($troli_detail);

            $troli = Troli::where('id',$id)->first();
            if(!empty($troli_detail->id)){
                $troli->tipe_discount = 'fixed';
                $troli->discount = '50000';
                $troli->total = $troli->subtotal - $troli->discount;
                $troli->kupon_kode = $request->kodekupon;
                $troli->update();
                alert()->success('Anda mendapatkan discount Rp 50,000 untuk produk ('.$troli_detail->produk_kode.') '.$troli_detail->produk, '');
            }else{
                alert()->info('Kode Kupoan yang anda masukan, tidak berlaku untuk produk yang ada pada Troli Anda', 'info');
            }
        }
        elseif($request->kodekupon == 'FA333'){ 
            //3.	Discount code: FA333 akan memberikan diskon 6% untuk barang diatas 400 ribu
            $disc = TroliDetail::where('harga', '>', 400000)->sum('subtotal');

            $troli = Troli::where('id',$id)->first();
            if($disc > 0){
                $discP = $disc*(6/100);
                $troli->tipe_discount = 'fixed';
                $troli->discount = $discP;
                $troli->total = $troli->subtotal - $troli->discount;
                $troli->kupon_kode = $request->kodekupon;
                $troli->update();
                alert()->success('Anda mendapatkan discount 6% untuk barang diatas Rp 400,000', 'Info');
            }else{
                alert()->warning('Tidak ditemukan untuk barang diatas Rp 400,000', 'Info');
            }
        }
        elseif($request->kodekupon == 'FA444'){
            //4.	Discount code: FA444 akan memberikan diskon 5% jika pelanggan membeli di hari selasa jam 13:00 s/d 15:00
            $time = Carbon::now()->timezone('Asia/Jakarta');
            $start = Carbon::create($time->year, $time->month, $time->day, 13, 0, 0); //set time to 11:00
            $end = Carbon::create($time->year, $time->month, $time->day, 15, 0, 0); //set time to 15:00
            
            $day = date('D');
            if($day == 'Tue'){
                if($time ->between($start, $end, true)) {
                    $troli = Troli::where('id',$id)->first();
                    $troli->tipe_discount = 'percent';
                    $troli->discount = '5';
                    $troli->total = $troli->subtotal - ($troli->subtotal*($troli->discount/100));
                    $troli->kupon_kode = $request->kodekupon;
                    $troli->update();
                    alert()->success('Kupon berhasil dimasukan', 'info');
                } else {
                    alert()->info('Kupon tidak berlaku saat ini', 'Info');
                }
            }
            else{
                alert()->info('Kupon tidak berlaku saat ini', 'Info');
            }
        }
        else{
            alert()->warning('Tidak terjadi transaksi kupon', 'info');
        }

        return redirect('/'.$id);
        //dd($request);
    }
}