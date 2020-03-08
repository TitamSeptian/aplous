@extends('laporan.layout-nota')
@section('nama_outlet', $data->outlet->nama)
@section('alamat_outlet', $data->outlet->alamat)
@section('tanggal_masuk', $masuk)
@section('estimasi', $esti)
@section('petugas', $data->tbUser->nama)
@section('pelanggan', $data->member->nama)
@section('list')
<input type="hidden" name="pajak" id="pajakVal" value="{{ $data->pajak }}">
<input type="hidden" name="diskon" id="diskonVal" value="{{ $data->diskon == null ? '0' : $data->diskon }}">
@foreach($data->detailTransaksi as $q)
<tr class="item">
    <td>
        {{ $q->paket->nama_paket }}
        <br>
        <span style="font-size: 9px;" class="harga">{{ $q->paket->harga }}</span>
    </td>
    <td class="text-center qty" data-qty="4">{{ $q->qty }}</td>
    <td class="text-right harga-tot" ></td>
</tr>
@endforeach

@endsection
@section('pajak', $data->pajak.'%')
@section('biaya_tambah', $data->biaya_tambahan)
@section('kode_invoice', $data->kode_invoice)
@section('redir', route('transaksi.index'))