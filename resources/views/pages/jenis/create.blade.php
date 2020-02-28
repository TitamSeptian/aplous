<form id="form-store" action="{{ route('jenis.store') }}">
	@csrf
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" >
	</div>
	<div class="form-group">
		<label>Keterangan</label>
		<textarea name="ket" id="ket"  class="form-control"></textarea>
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Tambah</button>
</form>