@extends('laporan.layout-pdf')
@section('content')
<div class="gd">
    <div class="g-12" style="text-align: center !important;">
        <h2>Laporan Paket</h2>
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
        <td>Paket</td>
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
<table class="table">
    <thead>
        <tr style="background-color: #ddd;">
            <th scope="col">Outlet</th>
            <th scope="col">Nama</th>
            <th scope="col">Harga(Rp)</th>
            <th scope="col">Jenis</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{ $data }} --}}
        @foreach($data as $j)
        <tr>
            <td scope="row">{{ $j->outlet->nama }}</td>
            <td >{{ $j->nama_paket }}</td>
            <td>{{ $j->harga }}</td>
            <td>{{ $j->jenis->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<table class="table">
    <thead>
        <tr style="background-color: #ddd;">
            <th scope="col">Nama</th>
            <th scope="col">Harga(Rp)</th>
            <th scope="col">Jenis</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $j)
        <tr>
            <td >{{ $j->nama_paket }}</td>
            <td>{{ $j->harga }}</td>
            <td>{{ $j->jenis->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
