<form id="form-store" action="{{ route('member.store') }}">
	@csrf
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" >
	</div>
	<div class="form-group">
		<label>No. Telepon</label>
		<input type="text" name="tlp" id="tlp" class="form-control" autocomplete="off" >
	</div>
	<div class="form-group">
		<label>Jenis Kelamin</label>
		<select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
			<option value="L">Laki - laki</option>
			<option value="P">Perempuan</option>
		</select>
	</div>
	<div class="form-group">
		<label>Alamat</label>
		<textarea name="alamat" id="alamat"  class="form-control"></textarea>
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Tambah</button>
</form>