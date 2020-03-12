@extends('partials.master', [$titlePage = 'Laporan', $activePage = 'laporan', $miniMenu = ''])
@section('content')
<div id="accordion" class="custom-accordion mb-4">
    {{-- paket --}}
    <div class="card mb-0">
        <div class="card-header">
            <h5 class="m-0">
                <a class="custom-accordion-title d-block pt-2 pb-2 text-muted" 
                    data-toggle="collapse" 
                    href="#paketColl" 
                    aria-expanded="true" 
                    aria-controls="paketColl">
                    <i class="fas fa-shopping-cart"></i> Paket <span class="float-right"><i class="mdi mdi-chevron-down accordion-arrow"></i></span>
                </a>
            </h5>
        </div>
        <div id="paketColl" class="collapse" data-parent="#accordion">
            <div class="card-body">
                <div class="d-flex">
                <a href="{{ route('paket.pdf') }}" class="badge badge-danger badge-pill"><i class="far fa-file-pdf"></i> Paket</a>
                @if(Auth::user()->level == 'admin')
                @foreach($outlet as $a)
                    <a href="{{ route('paket.pdf.outlet', $a->id) }}" class="ml-3 badge badge-danger badge-pill"><i class="far fa-file-pdf"></i> Paket {{ $a->nama }}</a>
                @endforeach
                @endif
                </div>
            </div>
        </div>
    </div> <!-- end card-->
    {{-- member --}}
    <div class="card mb-0">
        <div class="card-header">
            <h5 class="m-0">
                <a class="custom-accordion-title d-block pt-2 pb-2 text-muted" 
                    data-toggle="collapse" 
                    href="#memberColl" 
                    aria-expanded="true" 
                    aria-controls="memberColl">
                    <i class="fas fa-user"></i> Member <span class="float-right"><i class="mdi mdi-chevron-down accordion-arrow"></i></span>
                </a>
            </h5>
        </div>
        <div id="memberColl" class="collapse" data-parent="#accordion">
            <div class="card-body">
                <a href="{{ route('member.pdf') }}" class="badge badge-danger badge-pill"><i class="far fa-file-pdf"></i> Member</a>
            </div>
        </div>
    </div> <!-- end card-->
    {{-- outlet --}}
    @if(Auth::user()->level == 'admin')
    <div class="card mb-0">
        <div class="card-header">
            <h5 class="m-0">
                <a class="custom-accordion-title d-block pt-2 pb-2 text-muted" 
                    data-toggle="collapse" 
                    href="#outletColl" 
                    aria-expanded="true" 
                    aria-controls="outletColl">
                    <i class="fas fa-hospital-alt"></i> Outlet <span class="float-right"><i class="mdi mdi-chevron-down accordion-arrow"></i></span>
                </a>
            </h5>
        </div>
        <div id="outletColl" class="collapse" data-parent="#accordion">
            <div class="card-body">
                <a href="{{ route('outlet.pdf') }}" class="badge badge-danger badge-pill"><i class="far fa-file-pdf"></i> Outlet</a>
            </div>
        </div>
    </div> <!-- end card-->
    @endif
    {{-- transaksi --}}
    <div class="card mb-0">
        <div class="card-header">
            <h5 class="m-0">
                <a class="custom-accordion-title d-block pt-2 pb-2 text-muted" 
                    data-toggle="collapse" 
                    href="#transaksiColl" 
                    aria-expanded="true" 
                    aria-controls="transaksiColl">
                    <i class="fas fa-calendar-check"></i> Transaksi <span class="float-right"><i class="mdi mdi-chevron-down accordion-arrow"></i></span>
                </a>
            </h5>
        </div>
        <div id="transaksiColl" class="collapse" data-parent="#accordion">
            <div class="card-body">
                <span class="badge badge-cyan badge-pill">Transaksi</span>
            </div>
        </div>
    </div> <!-- end card-->
</div> <!-- end custom accordions-->
@endsection
