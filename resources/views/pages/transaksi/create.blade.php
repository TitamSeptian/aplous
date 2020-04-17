@extends('partials.master', [$titlePage = 'Transaksi', $activePage = 'transaksi', $miniMenu = 'transaksi'])
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/assets/extra-libs/select2/css/select2.min.css') }}">
<style>
    input.cl-line {
        border: none;
        background-color: #fff;
    }

    .tot{
        color: #858796;
    }

    .grey-line{
        display: block;
        padding: 0.100rem 0.05rem;
        font-size: 1rem;
        font-weight: 400;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        width:70px;
        height: 30px;
    }
</style>
@endpush
@section('content')
<div class="">
    <a href="/transaksi" class="btn btn-danger btn-sm mb-4">Kembali</a>
    <button type="button" class="fresh btn btn-sm btn-outline-secondary ml-auto float-right" id="fresh">Refresh</button>
</div>
<div class="card">
    <div class="card-body">
        <h3>Tambah Transaksi</h3>
        @if(Auth::user()->level == 'admin')
        <div class="form-group">
            <label>Toko</label>
            <select name="outlet" class="form-control" style="width: 100%" id="outlet"></select>
        </div>
        @endif
        
        
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Paket</label>
                    <input type="text" class="form-control" name="paket" id="paket" placeholder="Pilih Paket">
                    <input type="hidden" name="paketId" id="paket-id">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">jumlah KG/Satuan</label>
                    <input type="text" name="" class="form-control" class="qty" id="qty" placeholder="Quantitas" autocomplete="off">
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-block btn-sm btn-outline-primary" id="tambah">Tambah</button>
        <hr>
        <h4 id="jml-barang" style="font-weight: bold;">
            Jumlah Barang : 0
        </h4>
        <form method="POST" action="{{ route('transaksi.store') }}" id="form-transaksi">
            @csrf
            <input type="hidden" name="hd_outlet" id="hd_outlet">
            <input type="hidden" name="hd_member" id="hd_member">
            <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Paket</th>
                    <th>KG/Satuan</th>
                    <th>Harga</th>
                    <th>Ket</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody" data-cek="false">
                
            </tbody>
            </table>
            <h4 id="subtot" style="font-weight: bold;">
                Sub Total : 0
            </h4>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Estimasi Selesai</label>
                        <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" value="{{ $now }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Diskon(%)</label>
                        <input type="text" name="diskon" class="form-control" name="diskon" id="diskon" placeholder="Diskon" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Biaya Tambahan(Rp)</label>
                <input type="text" name="biaya_tambahan" id="biaya_tambahan" class="form-control" placeholder="Biaya Tambahan" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Pelanggan</label>
                <select name="member" class="form-control" style="width: 100%" id="member"></select>
            </div>
            <button type="button" id="btn-pesan" class="btn btn-block btn-success btn-sm">Pesan</button>
        </form>
    </div>
</div>
<div id="modalPaket" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Paket</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered no-wrap" id="tablePaket" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@push('js')
<script src="{{ asset('vendor/assets/extra-libs/select2/js/select2.min.js') }}"></script>
<script>
    $('body').on('change', '#outlet', function () {
        $('tablePaket').attr('data-outlet', $(this).val());
        $('#paket').val('');
        $(this).prop("disabled", true);
        // if (('#tbody').data('cek') == true) {
        //     ('#tbody').html('')
        // }else{
        //     ('#tbody').attr('data-cek', true)
        // }
    });
    @if(Auth::user()->level == 'admin')
        $('body').on('click', '#paket', function () {
            if ($('#outlet').val() == null) {
                Swal.fire({
                    title:'Peringatan !',
                    type:'warning',
                    text:"Pilih Toko",
                });
            }else{
                let id = $('#outlet').val()
                let url = 'http://127.0.0.1:8000/d/p/outlet?q='+id 
                $('#tablePaket').DataTable({
                    destroy: true,
                    ajax : url,
                    columns : [
                        {"data" : "nama_paket", render : function (a, b, c) {
                            return `<span data-s-nama="${c.nama_paket}" class="s-nama">${c.nama_paket}</span>`;
                        }},
                        {"data" : "harga", render : function (a,b,c) {
                            return `<span data-s-harga="${c.harga}" class="s-harga">${c.harga}</span>`;
                        }},
                        {"data" : "id", render : function (a,b,c) {
                             return `<a href="javascript:void(0)" data-s-id="${c.id}" data-harga=${c.harga} data-s-nama="${c.nama_paket}" class="s-id p-paket badge badge-info">Pilih</a>`;
                        }},
                    ]
                });
                $('#modalPaket').modal('show');
            }
        });
    @else
        $('body').on('click', '#paket', function () {
            let id = "{{ Auth::user()->tbUser->id_outlet }}"
            let url = 'http://127.0.0.1:8000/d/p/outlet?q='+id 
            $('#tablePaket').DataTable({
                destroy: true,
                ajax : url,
                columns : [
                    {"data" : "nama_paket", render : function (a, b, c) {
                        return `<span data-s-nama="${c.nama_paket}" class="s-nama">${c.nama_paket}</span>`;
                    }},
                    {"data" : "harga", render : function (a,b,c) {
                        return `<span data-s-harga="${c.harga}" class="s-harga">${c.harga}</span>`;
                    }},
                    {"data" : "id", render : function (a,b,c) {
                         return `<a href="javascript:void(0)" data-s-id="${c.id}" data-harga=${c.harga} data-s-nama="${c.nama_paket}" class="s-id p-paket badge badge-info">Pilih</a>`;
                    }},
                ]
            });
            $('#modalPaket').modal('show');
        });
    @endif

    $('body').on('click', '.p-paket',function (e) {
        e.preventDefault();
        let id = $(this).attr('data-s-id');
        let nama = $(this).attr('data-s-nama');
        paket.val(nama);
        paket.attr('data-p-is', id)
        $('#modalPaket').modal('hide');
    });


    $('#outlet').select2({
        ajax: {
            url: "{{ route('outlet.data.sel2') }}",
            dataType: "json",
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                };
            },
            processResults: function(data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data.items
                };
            },
            cache: true
        },
        placeholder: 'Cari Toko',
        // minimumInputLength: 1,
        templateResult: function(repo) {
            if (repo.loading) {
                return repo.text;
            }
            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                '<div class="select2-result-stock__title"></div>' +
                '<p class="select2-result-stock__information"></p>' +
                '</div>'
            );

            $container.find(".select2-result-stock__title").text(repo.nama);
            $container.find(".select2-result-stock__information").text(repo.alamat);

            return $container;
            // return repo.name+"<br>"+"<span>Qyt : "+repo.quantity+"</span>";
        },
        templateSelection: function(repo) {
            $container = $(
                `<div class="selectionResult">
                        <div class="selectionResult__general"></div>
                    </div>`
            )
            $container.find('.selectionResult__general').html(repo.nama)
            if (repo.nama == undefined) {
                return repo.text
            }
            // return repo.name+'&nbsp&nbsp<i class="fa fa-archive"></i> '+repo.quantity || repo.text;
            return $container || repo.text
        }
    });
    // selcet2 member
    $('#member').select2({
        ajax: {
            url: "{{ route('member.data.sel2') }}",
            dataType: "json",
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                };
            },
            processResults: function(data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data.items
                };
            },
            cache: true
        },
        placeholder: 'Cari Pelanggan',
        // minimumInputLength: 1,
        templateResult: function(repo) {
            if (repo.loading) {
                return repo.text;
            }
            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                '<div class="select2-result-stock__title"></div>' +
                '<p class="select2-result-stock__information text-muted"></p>' +
                '</div>'
            );

            $container.find(".select2-result-stock__title").text(repo.nama);
            $container.find(".select2-result-stock__information").text(repo.tlp);

            return $container;
            // return repo.name+"<br>"+"<span>Qyt : "+repo.quantity+"</span>";
        },
        templateSelection: function(repo) {
            $container = $(
                `<div class="selectionResult">
                        <div class="selectionResult__general"></div>
                    </div>`
            )
            $container.find('.selectionResult__general').html(repo.nama)
            if (repo.nama == undefined) {
                return repo.text
            }
            // return repo.name+'&nbsp&nbsp<i class="fa fa-archive"></i> '+repo.quantity || repo.text;
            return $container || repo.text
        }
    });
</script>
<script src="{{ asset('js/transaksi.js') }}"></script>
@endpush
