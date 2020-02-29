<form id="form-edit" action="{{ route('paket.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Nama Paket</label>
        <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" value="{{ $data->nama_paket }}">
    </div>
    <div class="form-group">
        <label>Outlet</label>
        <select class="form-control" name="outlet" id="outlet" style="width: 100%">
            @foreach($outlet as $o)
            {{ $data->id == $o->id ? 'selected' : '' }}
            <option value="{{ $o->id }}" {{ $o->id == $data->id_outlet ? "selected" : "" }}>{{ $o->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" name="jenis" id="jenis" style="width: 100%">
            @foreach($jenis as $o)
            <option value="{{ $o->id }}" {{ $o->id == $data->id_jenis ? 'selected' : '' }}>{{ $o->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Harga</label>
        <input type="number" name="harga" id="harga" class="form-control" min="1" autocomplete="off" value="{{ $data->harga }}">
    </div>
    <button type="submit" class="btn btn-primary btn-sm float-right">Ubah</button>
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
        placeholder: 'Cari Outlet',
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
        },
    });

    // var outlet = $('#outlet');
    // outlet.val('{{ $data->id }}');
    // outlet.trigger('select2:select');

    $('#jenis').select2({
        ajax: {
            url: "{{ route('jenis.data.sel2') }}",
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
        placeholder: 'Cari Jenis',
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

            $container.find(".select2-result-stock__title").text(repo.name);
            $container.find(".select2-result-stock__information").text(repo.ket == null ? '-' : repo.ket);

            return $container;
            // return repo.name+"<br>"+"<span>Qyt : "+repo.quantity+"</span>";
        },
        templateSelection: function(repo) {
            $container = $(
            	`<div class="selectionResult">
					<div class="selectionResult__general"></div>
        		</div>`
        		)
            $container.find('.selectionResult__general').html(repo.name)
            if (repo.name == undefined) {
                return repo.text
            }
            // return repo.name+'&nbsp&nbsp<i class="fa fa-archive"></i> '+repo.quantity || repo.text;
            return $container || repo.text
        }
    });
})

</script>
