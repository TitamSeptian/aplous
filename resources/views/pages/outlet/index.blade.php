@extends('partials.master', [$titlePage = 'Outlet', $activePage = 'outlet'])
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex">
            <h3 class="">Outlet</h3>
            <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-3 ml-auto" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2</td>
                        <td>Lous 2</td>
                        <td>Bandung, Jalan cichaeum 35</td>
                        <td>08192386123912</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="badge badge-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="javascript:void(0)" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Lous 2</td>
                        <td>Bandung, Jalan cichaeum 35</td>
                        <td>08192386123912</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="badge badge-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="javascript:void(0)" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Lous 2</td>
                        <td>Bandung, Jalan cichaeum 35</td>
                        <td>08192386123912</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="badge badge-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="javascript:void(0)" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Lous 2</td>
                        <td>Bandung, Jalan cichaeum 35</td>
                        <td>08192386123912</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="badge badge-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="javascript:void(0)" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Lous 2</td>
                        <td>Bandung, Jalan cichaeum 35</td>
                        <td>08192386123912</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="badge badge-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="javascript:void(0)" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Lous 2</td>
                        <td>Bandung, Jalan cichaeum 35</td>
                        <td>08192386123912</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="badge badge-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="javascript:void(0)" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Lous 2</td>
                        <td>Bandung, Jalan cichaeum 35</td>
                        <td>08192386123912</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="badge badge-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="javascript:void(0)" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Lous 2</td>
                        <td>Bandung, Jalan cichaeum 35</td>
                        <td>08192386123912</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="badge badge-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="javascript:void(0)" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Lous 2</td>
                        <td>Bandung, Jalan cichaeum 35</td>
                        <td>08192386123912</td>
                        <td class="text-center">
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