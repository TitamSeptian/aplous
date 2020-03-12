@extends('laporan.layout-pdf')
@section('content')
<div class="gd">
    <div class="g-12" style="text-align: center !important;">
        <h2>Laporan Transaksi</h2>
        @if(Auth::user()->level != 'admin')
        <h3>{{ Auth::user()->tbUser->outlet->nama }}</h3>
        <p>{{ Auth::user()->tbUser->outlet->alamat }}</p>
        @endif
    </div>
</div>
<hr>
<table>
    <tr>
        <td width="150">Laporan</td>
        <td>:</td>
        <td>Transaksi</td>
    </tr>
    @if(Auth::user()->level != 'admin')
    <tr>
        <td>Outlet</td>
        <td>:</td>
        <td>{{ Auth::user()->tbUser->outlet->nama }}</td>
    </tr>
    @endif
    <tr>
        <td>Dibuat</td>
        <td>:</td>
        <td>{{ $tanggal }}</td>
    </tr>
</table>
<hr>
@if(Auth::user()->level == 'admin')
    @foreach($data as $j)
    <table>
        <tr>
            <td width="150">Kode</td>
            <td>:</td>
            <td><b>{{ $j->kode_invoice }}</b></td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>:</td>
            <td>{{ $j->member->nama }}</td>
        </tr>
        <tr>
            <td>Outlet</td>
            <td>:</td>
            <td>{{ $j->outlet->nama }}</td>
        </tr>
        <tr>
            <td>Tanggal Masuk</td>
            <td>:</td>
            <td>{{ Date::parse($j->tgl)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Estimasi</td>
            <td>:</td>
            <td>{{ Date::parse($j->batas_waktu)->format('d F Y')  }}</td>
        </tr>
        <tr>
            <td>Biaya Tambahan</td>
            <td>:</td>
            <td>{{ $j->biaya_tambahan == null ? '-' : $j->biaya_tambahan }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td><b>{{ $j->status }}</b></td>
        </tr>    
    </table>
    {{-- barang paket yang di pesan --}}
    <table class="table">
        <thead>
            <tr style="background-color: #ddd;">
                <th scope="col">Paket</th>
                <th scope="col">Qty(Satuan/Kg)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($j->detailTransaksi as $a)
            <tr>
                <td scope="row">{{ $a->paket->nama_paket }}</td>
                <td>{{ $a->qty }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    @endforeach
@else
    @foreach($data as $j)
    <table>
        <tr>
            <td width="150">Kode</td>
            <td>:</td>
            <td><b>{{ $j->kode_invoice }}</b></td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>:</td>
            <td>{{ $j->member->nama }}</td>
        </tr>
        <tr>
            <td>Tanggal Masuk</td>
            <td>:</td>
            <td>{{ Date::parse($j->tgl)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Estimasi</td>
            <td>:</td>
            <td>{{ Date::parse($j->batas_waktu)->format('d F Y')  }}</td>
        </tr>
        <tr>
            <td>Biaya Tambahan</td>
            <td>:</td>
            <td>{{ $j->biaya_tambahan == null ? '-' : $j->biaya_tambahan }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td><b>{{ $j->status }}</b></td>
        </tr>    
    </table>
    {{-- barang paket yang di pesan --}}
    <table class="table">
        <thead>
            <tr style="background-color: #ddd;">
                <th scope="col">Paket</th>
                <th scope="col">Qty(Satuan/Kg</th>
            </tr>
        </thead>
        <tbody>
            @foreach($j->detailTransaksi as $a)
            <tr>
                <td scope="row">{{ $a->paket->nama_paket }}</td>
                <td>{{ $a->qty }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    @endforeach
@endif
@endsection
