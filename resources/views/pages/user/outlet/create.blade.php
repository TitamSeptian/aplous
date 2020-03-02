<form id="form-store" action="{{ route('user.store') }}">
	@csrf
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" >
	</div>
    <label>Peran</label>
    <div class="form-group d-flex">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="role" value="kasir" checked>
            <label class="form-check-label" for="role">Kasir</label>
        </div>
        <div class="form-check ml-4">
            <input class="form-check-input" type="radio" name="role" id="role" value="owner">
            <label class="form-check-label" for="role">Owner</label>
        </div>
    </div>
	{{-- <div class="form-group">
		<label>Peran</label>
		<select name="role" id="role" class="form-control">
			<option value="kasir">Kasir</option>
			<option value="owner">Owner</option>
		</select>
	</div> --}}
	<div class="form-group outlet">
		<label>Outlet</label>
		<select name="outlet" class="form-control" required style="width: 100%" id="outlet"></select>
	</div>
	<hr>
	<div class="form-group">
		<label>username</label>
		<input type="text" name="username" id="username"  class="form-control">
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type="password" name="password" id="password"  class="form-control">
	</div>
	<div class="form-group">
		<label>Konfirmasi Password</label>
		<input type="password" name="password_confirmation" id="password"  class="form-control">
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Tambah</button>
</form>
<script>
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
        }
    });
</script>