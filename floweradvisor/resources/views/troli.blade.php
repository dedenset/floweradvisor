@extends('troli-template')
@section('content-wrapper')
<div class="content2 cart-main">
<span class="cart-body-cont">
<div class="cart-container">
 <div class="row">
    <div class="col-md-12 mb-5">
        <center>
        <h1>Troli Anda</h1>
        </center>
    </div>
 </div>
 

<!--
<div class="notice">
<div class="success-code hidden">
<p>Sedang memperbaharui troli, mohon tunggu...</p>
</div>
<div class="success-code success-code1 hidden">
<p>Berhasil memasukkan kode promo</p>
</div>
<div class="failed-code hidden">
<p>Maaf! kode promo yang anda masukkan tidak valid</p>
</div>
</div>
-->

<div class="cart-table">
<div class="cart-header">
<div class="cart-filler"> </div>
<div class="c-prod">Produk</div>
<div class="c-price">Pilih Harga</div>
<div class="c-qty">Kuantitas</div>
<div class="c-subtot">Subtotal</div>
<div class="c-remove">Hapus</div>
</div>

@foreach($troli_details as $td)

<div class="cart-content cart-{{ $td->produk_kode }}">
<div class="cart-img">
<a href="#"><img src="{{ $td->gambar }}"></a>
</div>
<div class="c-prod">
<span class="b-name"><a href="#">{{ $td->produk }}</a></span>
<span class="b-id">{{ $td->produk_kode }}</span>
 <span class="b-id crimson"></span>
</div>
<div class="c-price">
<span class="b-price">
Rp {{ number_format($td->harga) }}
</span>
</div>
<div class="c-qty">
<div class="main-cart-qty">
<div class="add-min">
<a class="up" data-code="{{ $td->id }}"><i class="fa fa-chevron-up qty-up" style="cursor:pointer;"></i></a>
<form method="post" id="up{{ $td->id }}" action="{{ url('/'.$td->id )}}"/>
    @csrf
    <input  type="hidden" name="tipe" value="up">
    <input  type="hidden" name="qty" value="1">
</form>

<a class="down" data-code="{{ $td->id }}"><i class="fa fa-chevron-down qty-down" style="cursor:pointer;"></i></a>
<form method="post" id="down{{ $td->id }}" action="{{ url('/'.$td->id )}}"/>
    @csrf
    <input  type="hidden" name="tipe" value="down">
    <input  type="hidden" name="qty" value="1">
</form>
</div>
    <input type="text" data-code="{{ $td->produk_kode }}" class="c-i-qty" value="{{ $td->qty }}" inum="qty{{ $td->id }}">
</div>
</div>
<div class="c-subtot">
<span class="b-price subtotal-FA4532">Rp {{ number_format($td->subtotal) }}</span>
</div>
<div class="c-remove">
<span class="cart-remove">
<a><i class="fa fa-times del" style="cursor:pointer;" data-id="{{ $td->id }}"></i></a>
<form method="post" id="del{{ $td->id }}" action="{{ url('/'.$td->id )}}"/>
    @csrf
    <input type="hidden" name="_method" value="DELETE"/>
    <input  type="hidden" name="tipe" value="down">
    <input  type="hidden" name="qty" value="1">
</form>

</span>
</div>
</div>
@endforeach

<div class="row discount-row" align="left">
<div class="col-md-7 col-xs-7"></div>
<div class="col-md-5 col-xs-5">
<a href="#" class="discount-text" data-toggle="modal" data-target="#exampleModal">
    <img src="https://img.floweradvisor.com/images/discount-ico.png">
    <span class='text btnDisc'> Gunakan Kode Diskon/Reward</span>
</a>
</div>
</div>

@if(!empty($trolis->tipe_discount))

<div class="cart-result dashtop1-black">
<div class="result-filler"></div>
<div class="c-sub">
    <span class="result-sub pull-left">Sub Total</span>
</div>
<div class="c-subtot">
    <span class="c-total">Rp {{ number_format($trolis->subtotal) }}</span>
</div>
</div>

<div class="cart-result">
<div class="result-filler"></div>
<div class="c-sub">
    <span class="result-sub pull-left">Discount {{ $discTipe }}</span>
</div>
<div class="c-subtot">
    <span class="c-total">
        @if($trolis->tipe_discount == 'fixed')
            Rp -{{ number_format($trolis->discount) }}
        @else
            {{ $discTotalView }}
        @endif
    </span>
</div>
<div class="result-filler2"></div>
</div>
@endif


<div class="cart-result dashtop1-black">
<div class="result-filler"></div>
<div class="c-sub">
<span class="result-sub pull-left">Total</span>
</div>
<div class="c-subtot">
<span class="c-total">Rp {{ number_format($trolis->total) }}</span>
</div>
<div class="result-filler2"></div>
</div>

<div class="cart-result dashtop1-black"></div>


</div>
</div>
</div>
@stop
