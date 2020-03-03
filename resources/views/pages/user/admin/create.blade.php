<form id="form-store" action="{{ route('admin.store') }}">
	@csrf
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" >
	</div>
	<div class="form-group">
		<label>username</label>
		<input type="text" name="username" id="username"  class="form-control">
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type="password" name="password" id="password"  class="form-control" >
	</div>
	<div class="form-group">
		<label>Konfirmasi Password</label>
		<input type="password" name="password_confirmation" id="password"  class="form-control" >
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Tambah</button>
</form>