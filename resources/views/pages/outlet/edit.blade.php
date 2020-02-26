<form id="form-edit" action="{{ route('outlet.update', $data->id) }}">
	@csrf
	@method('PUT')
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" value="{{ $data->nama }}">
	</div>
	<div class="form-group">
		<label>No. Telepon</label>
		<input type="number" name="tlp" id="tlp" class="form-control" autocomplete="off" value="{{ $data->tlp }}">
	</div>
	<div class="form-group">
		<label>Alamat</label>
		<textarea name="alamat" id="alamat"  class="form-control">{{ $data->alamat }}</textarea>
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Ubah</button>
</form>