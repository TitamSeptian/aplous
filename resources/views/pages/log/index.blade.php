@extends('partials.master', [$titlePage = 'Riwayat', $activePage = 'riwayat', $miniMenu = ''])
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex">
            <h3 class="">Riwayat</h3>
        </div>
        <br>
        <div class="form-row">
            <div class="col-md-8">
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary btn-refresh mt-3">Refresh</a>
                <a href="javascript:void(0)" data-url="{{ route('log.delete-all') }}" class="btn btn-sm btn-outline-danger btn-delete-all ml-3 mt-3">Hapus</a>
            </div>
            <div class="col-md-4">
                <input type="text" name="cari" class="form-control mt-3 mb-3" id="cari" placeholder="Cari Riwayat">
            </div>
        </div>
        <div class="table-responsive">
            <table id="tableLog" class="table table-striped table-bordered no-wrap" style="width: 100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Aksi</th>
                        <th>Waktu</th>
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
    let table =$('#tableLog').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bFilter: true,
        bLengthChange: false, // un active show entri
        ajax: "{{ route('log.data') }}",
        columns: [
            { data: "user" },
            { data: "msg" },
            { data: "time" },
            { data: 'action', orderable: false, searchable: false },
        ]
    })

    // hide default search
    let def_search = $('div#tableLog_filter');
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
                'place' : 'Riwayat'
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
<script src="{{ asset('js/log.js') }}"></script>
@endpush