@extends('partials.master', [$titlePage = 'Dashboard', $activePage = 'dashboard', $miniMenu=''])
@section('content')
<div class="card-group">
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <div class="d-inline-flex align-items-center">
                        <h2 class="text-dark mb-1 font-weight-medium">10</h2>
                    </div>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pengguna</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">23</h2>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Cucian
                    </h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i class="icon-social-dropbox"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <div class="d-inline-flex align-items-center">
                        <h2 class="text-dark mb-1 font-weight-medium">20</h2>
                    </div>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Produk</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i class="fas fa-shopping-cart"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <h2 class="text-dark mb-1 font-weight-medium">4</h2>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Outlet</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i class="fas fa-hospital-alt"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>  

{{-- me --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Paket</th>
                        <th>Kode</th>
                        <th>Member</th>
                        <th>Satuan</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="badge badge-light-warning">Dicuci</span></td>
                        <td>
                            <a href="javascript:void(0)" class="font-weight-medium link">
                                Kiloan
                            </a>
                        </td>
                        <td><a href="javascript:void(0)" class="font-bold link">LOU0001</a></td>
                        <td>Jhon Doe</td>
                        <td>1 KG</td>
                        <td>2020 - 09 - 01</td>
                        <td>2020 - 09 - 03</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Status</th>
                        <th>Paket</th>
                        <th>Kode</th>
                        <th>Member</th>
                        <th>Satuan</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                    </tr>
                </tfoot>
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