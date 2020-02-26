<form id="form-store" action="{{ route('outlet.store') }}">
	@csrf
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" >
	</div>
	<div class="form-group">
		<label>No. Telepon</label>
		<input type="number" name="tlp" id="tlp" class="form-control" autocomplete="off" >
	</div>
	<div class="form-group">
		<label>Alamat</label>
		<textarea name="alamat" id="alamat"  class="form-control"></textarea>
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Tambah</button>
</form>