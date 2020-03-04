@extends('partials.master', [$titlePage = 'Transaksi', $activePage = 'transaksi', $miniMenu = ''])
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/assets/extra-libs/select2/css/select2.min.css') }}">
@endpush
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex">
            <h3 class="">Transaksi</h3>
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm mb-3 ml-auto"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        <div class="table-responsive">
            <table id="tableTransaksi" class="table table-striped table-bordered no-wrap">
                <thead>
                    <tr>
                        <th>1</th>
                        <th>Kode</th>
                        <th>Member</th>
                        <th>Harga</th>
                        <th>status pembayaran</th>
                        <th>status cucian</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('vendor/assets/extra-libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/transaksi.js') }}"></script>
@endpush
