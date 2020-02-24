@extends('partials.master', [$titlePage = 'Transaksi', $activePage = 'transaksi'])
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex">
            <h3 class="">Transaksi</h3>
            <a href="/transaksi/create" class="btn btn-primary btn-sm mb-3 ml-auto"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered no-wrap">
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
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>LOU0002</td>
                        <td>Jhon Doe</td>
                        <td>harga</td>
                        <td class="text-danger">Belum Dibayar</td>
                        <td class="text-secondary">baru</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="badge badge-info"><i class="fas fa-eye"></i> Detail</a>
                            <a href="javascript:void(0)" class="badge badge-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="javascript:void(0)" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>LOU0003</td>
                        <td>Jhon Doe</td>
                        <td>harga</td>
                        <td class="text-success">Dibayar</td>
                        <td class="text-success">Selesai</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="badge badge-info"><i class="fas fa-eye"></i> Detail</a>
                            <a href="javascript:void(0)" class="badge badge-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="javascript:void(0)" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <ul class="pagination float-right">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
            </div>
        </div>
    </div>
</div>

@endsection