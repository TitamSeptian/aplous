<form id="form-edit" action="{{ route('user.update', $data->id) }}">
	@csrf
	@method('PUT')
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" 
			value="{{ $data->level == 'admin' ? $data->admin->nama : $data->tbUser->nama }}">
	</div>
	<div class="form-group">
		<label>Peran</label>
		<select type="text" name="role" id="role" class="form-control" autocomplete="off" data-role="{{ $data->level }}">
			@if($data->level == 'admin')
			<option value="admin" {{ $data->level == 'admin' ? 'selected' : '' }}>Admin</option>
			<option value="owner">Owner</option>
			<option value="kasir">Kasir</option>
			@else
			<option value="admin">Admin</option>
			<option value="owner" {{ $data->tbUser->role == 'owner' ? 'selected' : ''}}>Owner</option>
			<option value="kasir" {{ $data->tbUser->role == 'kasir' ? 'selected' : ''}}>Kasir</option>
			@endif
		</select>
	</div>
	@if($data->level == 'outlet')
	<input type="hidden" name="outlet" value="{{ $data->tbUser->id_outlet }}">
	@endif
	<div class="form-group outlet">
		<label>Outlet</label>
		<select class="form-control" id="outlet" name="outlet_n" style="width: 100%">
			@if($data->level == 'outlet')
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
		<input name="password" id="password" class="form-control" placeholder="JTidak Perlu diisi jika tidak ada perubahan">
	</div>
	<div class="form-group">
		<label>Konfirmasi Password</label>
		<input name="password_confirmation" id="password" class="form-control" placeholder="JTidak Perlu diisi jika tidak ada perubahan">
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Ubah</button>
</form>
<script>
	if ( $('#role').data('role') == 'admin') {
		$('#outlet').removeAttr('required')
		$('.outlet').hide()
	}else{
        $('#outlet').attr('required', '')
		$('.outlet').show()
	}
	$('#role').on('change', function (e) {
		const a = $(this).find(':selected').val();
		if (a == 'admin') {
            $('#outlet').removeAttr('required')
			$('.outlet').hide()
		}else{
            $('#outlet').attr('required', '')
			$('.outlet').show()
		}
	})
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