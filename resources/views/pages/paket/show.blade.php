<div class="container">
	<div class="row">
		<div class="col-md-5">
			<p class="mb-3">Nama :</p>
			<p class="mb-3">No. Telepon :</p>
			<p class="mb-3">Alamat :</p>
			<p class="mb-3">Harga :</p>
		</div>
		<div class="col-md-7">
			<p class="mb-3">{{ $data->nama_paket }}</p>
			<p class="mb-3">{{ $data->outlet->nama }}</p>
			<p class="mb-3">{{ $data->jenis->name }}</p>
			<p class="mb-3"><b>{{ $data->harga }}</b></p>
		</div>
	</div>
</div>