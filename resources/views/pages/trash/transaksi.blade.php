@extends('partials.master', [$titlePage = 'Sampah', $activePage = 'trash', $miniMenu = 'transaksi'])
@section('content')
{{-- =============================================================== --}}
{{-- ========================        Outlet     =================== --}}
{{-- =============================================================== --}}
<div class="card">
    <div class="card-body">
        <h3 class="mb-3">Transaksi</h3>
        <div class="form-row">
            <div class="col-md-8 mt-3">
                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-restore-all-outlet" data-url="{{ route('transaksi.softDelete.all') }}">Kembalikan</a>
                <a href="javascript:void(0)" class="ml-1 btn btn-sm btn-danger btn-delete-all-outlet" data-url="{{ route('transaksi.softDelete.all') }}">Hapus</a>
                <a href="javascript:void(0)" class="ml-1 btn btn-sm btn-secondary btn-refresh">Segarkan</a>
            </div>
            <div class="col-md-4">
                <input type="text" name="cari" class="form-control mt-3 mb-3" id="cariTransaksi" placeholder="Cari Transaksi">
            </div>
        </div>
        <div class="table-responsive">
            <table id="tableTransaksi" class="table table-striped table-bordered no-wrap" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Dihapus</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let tableTitle = "Transaksi";
    let table = $('#tableTransaksi').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bFilter: true,
        bLengthChange: false, // un active show entri
        ajax: "{{ route('transaksi.softDelete.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "kode_invoice" },
            { data: "delete_time" },
            { data: 'action', orderable: false, searchable: false },
        ],
        oLanguage: {
            sEmptyTable: tableTitle+ " Masih Kosong",
            sInfo: "Total _TOTAL_ "+tableTitle+" Untuk Ditampilkan (_START_ - _END_)",
            sInfoFiltered: " - Dari _MAX_ "+ tableTitle,
            sLoadingRecords: "Memuat...",
            sZeroRecords: tableTitle+ "Tidak Ditemukan",
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

    // define function search
    var search = $.fn.dataTable.util.throttle(function(val) {
            table.search(val).draw();
        }, 400  // Search delay in ms
    );

    // delay funcyion
    function delay(callback, ms) {
        let timer = 0;
        return function() {
            let context = this, 
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
              callback.apply(context, args);
            }, ms || 0);
        };
    }

    // fill the serach input
    $('#cariTransaksi').keyup(delay(e => {
        search(e.target.value)
        $.ajax({
            url: "{{ route('log.search.store') }}",
            type: 'post',
            data: {
                'search' : e.target.value,
                'place' : 'Sampah Transaksi'
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