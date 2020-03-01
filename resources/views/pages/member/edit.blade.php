<form id="form-edit" action="{{ route('member.update', $data->id) }}">
	@csrf
	@method('PUT')
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" value="{{ $data->nama }}">
	</div>
	<div class="form-group">
		<label>No. Telepon</label>
		<input type="text" name="tlp" id="tlp" class="form-control" autocomplete="off" value="{{ $data->tlp }}">
	</div>
	<div class="form-group">
		<label>Jenis Kelamin</label>
		<select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
			<option value="L" {{ $data->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki - laki</option>
			<option value="P" {{ $data->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
		</select>
	</div>
	<div class="form-group">
		<label>Alamat</label>
		<textarea name="alamat" id="alamat"  class="form-control">{{ $data->alamat }}</textarea>
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Ubah</button>
</form>