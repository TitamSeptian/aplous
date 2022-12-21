@extends('partials.master', [($titlePage = 'Jenis'), ($activePage = 'jenis'), ($miniMenu = '')])
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h3 class="">Jenis</h3>
                <a href="javascript:void(0)" class="btn btn-success btn-sm mb-3 ml-auto" id="btn-create"
                    data-url="{{ route('jenis.create') }}" data-toggle="modal" data-target="#modal-lg">Tambah</a>
            </div>
            <br>
            <div class="form-row">
                <div class="col-md-8">
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary btn-refresh mt-3">Segarkan</a>
                </div>
                <div class="col-md-4">
                    <input type="text" name="cari" class="form-control mt-3 mb-3" id="cari"
                        placeholder="Cari Jenis">
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableJenis" class="table table-striped table-bordered no-wrap" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Ket</th>
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
        let tableTitle = "Jenis";
        let table = $('#tableJenis').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            bFilter: true,
            bLengthChange: false, // un active show entri
            ajax: "{{ route('jenis.data') }}",
            columns: [{
                    data: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "name"
                },
                {
                    data: "ket",
                    "render": (a, b, c) => {
                        if (c.ket == null) {
                            return '-'
                        } else {
                            return c.ket
                        }
                    }
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
        let def_search = $('div#tableJenis_filter');
        def_search.css('display', 'none');

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
                    'place': 'Jenis'
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
    <script src="{{ asset('js/jenis.js') }}"></script>
@endpush
