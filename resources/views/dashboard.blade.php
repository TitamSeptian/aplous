@extends('partials.master', [$titlePage = 'Dashboard', $activePage = 'dashboard', $miniMenu=''])
@section('content')
<div class="card-group">
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <div class="d-inline-flex align-items-center">
                        <h2 class="text-dark mb-1 font-weight-medium">{{ count($member) }}</h2>
                    </div>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pelanggan</h6>
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
                    <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">{{ count($transaksi) }}</h2>
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
                        <h2 class="text-dark mb-1 font-weight-medium">{{ count($paket) }}</h2>
                    </div>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Paket </h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i class="fas fa-shopping-cart"></i></span>
                </div>
            </div>
        </div>
    </div>
    @if(Auth::user()->level == 'admin')
    <div class="card">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <h2 class="text-dark mb-1 font-weight-medium">{{ count($outlet) }}</h2>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Toko</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i class="fas fa-hospital-alt"></i></span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@if(Auth::user()->level == 'admin')
@foreach($outlet as $a)
<div class="card">
    <div class="card-body">
        <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
                <h3 class="text-dark mb-1 font-weight-medium">{{ $a->nama }}</h3>
                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">{{ $a->alamat }}</h6>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
                <span class="opacity-7 text-muted"><i class="fas fa-hospital-alt"></i></span>
            </div>
        </div>
        <hr>
        <table>
            <tr>
                <td width="100">Pemasukan</td>
                <td width="100">Pengeluaran</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    @php
                    $ts = App\Transaksi::where('id_outlet', $a->id)->get();
                    $total = 0;
                    foreach ($ts as $t) {
                        $dt = DB::table('tb_detail_transaksi')
                                ->join('tb_paket', 'tb_detail_transaksi.id_paket', '=', 'tb_paket.id')
                                ->select(DB::raw('SUM(tb_detail_transaksi.qty * tb_paket.harga) AS total'))
                                ->where('tb_detail_transaksi.id_transaksi', $t->id)
                                ->get();
                        foreach ($dt as $p) {
                            $sub_tot_number = (int) $p->total;
                            $pajak = 10/100 * $p->total;
                            $diskon = $t->diskon/100 * $p->total;
                            $total += $sub_tot_number - $diskon + $pajak + $t->biaya_tambahan;
                        }

                    }
                        echo($total);
                    @endphp
                </td>
                <td>
                    {{ $peng = \App\Pengeluaran::where('id_outlet', $a->id)->sum('harga') }}
                </td>
                <td class="d-flex">
                    @if($total >= $peng)
                        <span>Untung</span>
                        <span class="badge bg-success font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">+Rp.{{ $total - $peng }}</span>
                    @else
                        <span>Rugi</span>
                        <span class="badge bg-danger font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">-Rp.{{ $total - $peng }}</span>
                    @endif
                </td>
            </tr>

        </table>
    </div>
</div>
@endforeach


@endif
@if(Auth::user()->level == 'owner')
<div class="card">
    <div class="card-body">
        <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
                <h3 class="text-dark mb-1 font-weight-medium">Rekapitulasi</h3>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
                <span class="opacity-7 text-muted"><i class="fas fa-hospital-alt"></i></span>
            </div>
        </div>
        <hr>
        <table>
            <tr>
                <td width="100">Pemasukan</td>
                <td width="100">Pengeluaran</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    @php
                    $ts = App\Transaksi::where('id_outlet', Auth::user()->tbUser->id_outlet)->get();
                    $total = 0;
                    foreach ($ts as $t) {
                        $dt = DB::table('tb_detail_transaksi')
                                ->join('tb_paket', 'tb_detail_transaksi.id_paket', '=', 'tb_paket.id')
                                ->select(DB::raw('SUM(tb_detail_transaksi.qty * tb_paket.harga) AS total'))
                                ->where('tb_detail_transaksi.id_transaksi', $t->id)
                                ->get();
                        foreach ($dt as $p) {
                            $sub_tot_number = (int) $p->total;
                            $pajak = 10/100 * $p->total;
                            $diskon = $t->diskon/100 * $p->total;
                            $total += $sub_tot_number - $diskon + $pajak + $t->biaya_tambahan;
                        }

                    }
                        echo($total);
                    @endphp
                </td>
                <td>
                    {{ $peng = \App\Pengeluaran::where('id_outlet', Auth::user()->tbUser->id_outlet)->sum('harga') }}
                </td>
                <td class="d-flex">
                    @if($total >= $peng)
                        <span>Untung</span>
                        <span class="badge bg-success font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">+Rp.{{ $total - $peng }}</span>
                    @else
                        <span>Rugi</span>
                        <span class="badge bg-danger font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">-Rp.{{ $total - $peng }}</span>
                    @endif
                </td>
            </tr>

        </table>
    </div>
</div>
@endif

@endsection