@extends('partials.master', [($titlePage = 'Transaksi'), ($activePage = 'transaksi'), ($miniMenu = 'transaksi')])
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/assets/extra-libs/select2/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h3 class="">Transaksi</h3>
                <a href="{{ route('transaksi.create') }}" class="btn btn-success btn-sm mb-3 ml-auto">Tambah</a>
            </div>
            <br>
            <div class="form-row">
                <div class="col-md-8">
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary btn-refresh mt-3">Segarkan</a>
                </div>
                <div class="col-md-4">
                    <input type="text" name="cari" class="form-control mt-3 mb-3" id="cari"
                        placeholder="Cari Transaksi">
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableTransaksi" class="table table-striped table-bordered no-wrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Member</th>
                            {{-- <th>Harga</th> --}}
                            @if (Auth::user()->level == 'admin')
                                <th>Outlet</th>
                            @endif
                            {{-- <th>status pembayaran</th> --}}
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
    <script>
        let tableTitle = "Transaksi";
        let table = $('#tableTransaksi').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            bFilter: true,
            bLengthChange: false, // un active show entri
            ajax: "{{ route('transaksi.data') }}",
            columns: [{
                    data: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "kode_invoice",
                    orderable: false
                },
                {
                    data: "member.nama",
                    orderable: false
                },
                // { data: "total_harga" },
                @if (Auth::user()->level == 'admin')
                    {
                        data: "outlet.nama",
                        orderable: false
                    },
                @endif {
                    data: "status",
                    orderable: false
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            oLanguage: {
                sEmptyTable: tableTitle + " Masih Kosong",
                sInfo: "Total _TOTAL_ " + tableTitle + " Untuk Ditampilkan (_START_ - _END_)",
                sInfoFiltered: " - Dari _MAX_ " + tableTitle,
                sLoadingRecords: "Memuat...",
                sZeroRecords: tableTitle + "Tidak Ditemukan",
                sProcessing: "Sedang Memuat...",
                sInfoEmpty: tableTitle + " Tidak ada",
                oPaginate: {
                    sNext: "Selanjutnya",
                    sPrevious: "Sebelumnya",
                }
            }
        })

        // hide default search
        let def_search = $('div#tableTransaksi_filter');
        def_search.css('display', 'none');



        // previeus and next translate to indonesia
        // let prev = $('#tableTransaksi_previous');
        // // prev.html('Sebelumnya');
        // console.log(prev);

        // let next = $('li#tableTransaksi_next a');
        // next.html('Berikutnya')
        // define function search
        var search = $.fn.dataTable.util.throttle(function(val) {
                table.search(val).draw();
            }, 400 // Search delay in ms
        );

        // delay funcyion
        function delay(callback, ms) {
            let timer = 0;
            return function() {
                let context = this,
                    args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        // fill the serach input
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#cari').keyup(delay(e => {
            search(e.target.value)
            $.ajax({
                url: "{{ route('log.search.store') }}",
                type: 'post',
                data: {
                    'search': e.target.value,
                    'place': 'Transaksi'
                },
                success: res => {
                    console.log(res)
                    $('#cari').blur();
                },
                error: xhr => {
                    console.log(xhr)
                }
            })
        }, 500));
    </script>
    <script src="{{ asset('js/transaksi.js') }}"></script>
@endpush
