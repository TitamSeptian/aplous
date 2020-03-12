@extends('laporan.layout-pdf')
@section('content')
<div class="gd">
    <div class="g-12" style="text-align: center !important;">
        <h2>Laporan Pelanggan</h2>
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
        <td>Pelanggan</td>
    </tr>
    <tr>
        <td>Dibuat</td>
        <td>:</td>
        <td>{{ $tanggal }}</td>
    </tr>
</table>
<hr>
<table class="table">
    <thead>
        <tr style="background-color: #ddd;">
            <th scope="col">Nama</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">No. Telpon</th>
            <th scope="col">Alamat</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{ $data }} --}}
        @foreach($data as $m)
        <tr>
            <td scope="row">{{ $m->nama }}</td>
            <td >{{ $m->jenis_kelamin }}</td>
            <td>{{ $m->tlp }}</td>
            <td>{{ $m->alamat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
