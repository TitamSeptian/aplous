<form id="form-store" action="{{ route('pengeluaran.store') }}">
    @csrf
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" id="nama" class="form-control" autocomplete="off">
    </div>
    @if(Auth::user()->level == 'admin')
    <div class="form-group">
        <label>Toko</label>
        <select class="form-control" name="outlet" id="outlet" style="width: 100%"></select>
    </div>
    @endif
    <div class="form-group">
        <label>Harga</label>
        <input type="number" name="harga" id="harga" class="form-control" min="1" autocomplete="off">
    </div>
    <div class="form-group">
        <label>Keterangan</label>
        <textarea name="ket" id="ket" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-sm float-right">Tambah</button>
</form>
<script>
$(document).ready(function() {
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

})

</script>
