@extends('partials.master', [$titlePage = 'Paket', $activePage = 'paket', $miniMenu = ''])
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/assets/extra-libs/select2/css/select2.min.css') }}">
@endpush
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex">
            <h3 class="">Paket</h3>
            <a href="javascript:void(0)" class="btn btn-success btn-sm mb-3 ml-auto" id="btn-create" data-url="{{ route('paket.create') }}" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        <br>
        <div class="form-row">
            <div class="col-md-8">
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary btn-refresh mt-3">Refresh</a>            
            </div>
            <div class="col-md-4">
                <input type="text" name="cari" class="form-control mt-3 mb-3" id="cari" placeholder="Cari Paket">
            </div>
        </div>
        <div class="table-responsive">
            <table id="tablePaket" class="table table-striped table-bordered no-wrap" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Outlet</th>
                        <th>Harga</th>
                        <th class="text-center"></th>
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
    let table =$('#tablePaket').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bFilter: true,
        bLengthChange: false, // un active show entri
        ajax: "{{ route('paket.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "nama_paket" },
            { data: "outlet.nama" },
            { data: "harga" },
            { data: 'action', orderable: false, searchable: false },
        ]
    })

    // hide default search
    let def_search = $('div#tablePaket_filter');
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
                'search' : e.target.value,
                'place' : 'Paket'
            },
            success: res => {
                console.log(res)
            },
            error: xhr => {
                console.log(xhr)
            }
        })
    }, 500));
</script>
<script src="{{ asset('js/paket.js') }}"></script>
@endpush