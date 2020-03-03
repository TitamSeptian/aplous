<form id="form-edit" action="{{ route('admin.update', $data->id) }}">
	@csrf
	@method('PUT')
	<div class="form-group">
		<label>Nama</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" value="{{ $data->admin->nama }}">
	</div>
	<div class="form-group">
		<label>username</label>
		<input type="text" name="username" id="username"  class="form-control" value="{{ $data->username }}">
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type="password" name="password" id="password"  class="form-control" placeholder="Tidak Perlu diisi jika tidak ada perubahan">
	</div>
	<div class="form-group">
		<label>Konfirmasi Password</label>
		<input type="password" name="password_confirmation" id="password"  class="form-control" placeholder="Tidak Perlu diisi jika tidak ada perubahan">
	</div>
	<button type="submit" class="btn btn-primary btn-sm float-right">Ubah</button>
</form>