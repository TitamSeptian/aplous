<form id="form-edit" action="{{ route('jenis.update', $data->id) }}">
	@csrf
	@method('PUT')
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" value="{{ $data->name }}">
	</div>
	<div class="form-group">
		<label>Alamat</label>
		<textarea name="ket" id="ket"  class="form-control">{{ $data->ket }}</textarea>
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Ubah</button>
</form>