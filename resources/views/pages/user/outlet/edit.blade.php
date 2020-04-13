<form id="form-edit" action="{{ route('user.update', $data->id) }}">
	@csrf
	@method('PUT')
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" 
			value="{{ $data->level == 'admin' ? $data->admin->nama : $data->tbUser->nama }}">
	</div>

	<label>Peran</label>
    <div class="form-group d-flex">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="role" value="kasir" {{ $data->tbUser->role == 'kasir' ? 'checked' : '' }}>
            <label class="form-check-label" for="role">Kasir</label>
        </div>
        <div class="form-check ml-4">
            <input class="form-check-input" type="radio" name="role" id="role" value="owner" {{ $data->tbUser->role == 'owner' ? 'checked' : '' }}>
            <label class="form-check-label" for="role">Owner</label>
        </div>
    </div>

	<div class="form-group outlet">
		<label>Outlet</label>
		<select class="form-control" id="outlet" name="outlet" style="width: 100%">
			@if($data->level != 'admin')
				@foreach(\App\Outlet::all() as $q)
				<option value="{{ $q->id }}" {{ $data->tbUser->id_outlet == $q->id ? 'selected' : '' }}>{{ $q->nama }}</option>
				@endforeach
			@endif
		</select>
	</div>
	<div class="form-group">
		<label>Username</label>
		<input type="text" name="username" id="username" class="form-control" autocomplete="off" value="{{ $data->username }}">
	</div>
	<div class="form-group">
		<label>Password</label>
		<input name="password" type="password" id="password" class="form-control" placeholder="Tidak Perlu diisi jika tidak ada perubahan">
	</div>
	<div class="form-group">
		<label>Konfirmasi Password</label>
		<input name="password_confirmation" type="password" id="password" class="form-control" placeholder="Tidak Perlu diisi jika tidak ada perubahan">
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Ubah</button>
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