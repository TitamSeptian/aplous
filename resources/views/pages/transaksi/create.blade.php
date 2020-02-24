@extends('partials.master', [$titlePage = 'Transaksi', $activePage = 'transaksi'])
@section('content')
<a href="/transaksi" class="btn btn-danger btn-sm mb-4">Kembali</a>
<div class="card">
    <div class="card-body">
        <h3>Tambah Transaksi</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Member</label>
                    <select class="form-control">
                        <option>Jhon doe</option>
                        <option>Marinka</option>
                        <option>Juna</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Paket</label>
                    <select class="form-control">
                        <option>Klioan</option>
                        <option>Selimut</option>
                        <option>Bedkover</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Estimasi Selesai</label>
                    <input type="date" name="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Pajak</label>
                    <input type="number" name="" class="form-control">
                </div>

            </div>
        </div>
        <div class="form-group">
            <label for="">jumlah KG/Satuan</label>
            <input type="number" name="" class="form-control">
        </div>
        <button type="button" class="btn btn-block btn-sm btn-outline-primary">Tambah</button>
        <hr>
        Jumlah Barang : 3
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Paket</th>
                    <th>KG/Satuan</th>
                    <th>Harga</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Kiloan</td>
                    <td>1</td>
                    <td>20000</td>
                    <td><a href="javascript:void(0)" class="text-danger"><i class="fas fa-times"></i></a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Bed Cover</td>
                    <td>2</td>
                    <td>20000</td>
                    <td><a href="javascript:void(0)" class="text-danger"><i class="fas fa-times"></i></a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Bed Cover</td>
                    <td>2</td>
                    <td>20000</td>
                    <td><a href="javascript:void(0)" class="text-danger"><i class="fas fa-times"></i></a></td>
                </tr>
            </tbody>
        </table>
        Jumlah Harga : 60000
        <button type="submit" class="btn btn-block btn-success btn-sm">Pesan</button>
    </div>
</div>

@endsection