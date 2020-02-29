<div class="container">
	<table class="mb-3">
		<tr>
			<td width="200">Nama</td>
			<td width="10">:</td>
			<td>{{ $data->nama_paket }}</td>
		</tr>
		<tr>
			<td>Outlet</td>
			<td>:</td>
			<td>
				{{ $data->outlet->nama }}
				<br>
				<sup class="text-muted">{{ $data->outlet->alamat }}</sup>
			</td>
		</tr>
		<tr>
			<td>Jenis</td>
			<td>:</td>
			<td>{{ $data->jenis->name }}</td>
		</tr>
		<tr>
			<td>Harga</td>
			<td>:</td>
			<td><b>{{ $data->harga }}</b></td>
		</tr>
	</table>
	{{-- <div class="row">
		<div class="col-md-5">
			<p class="mb-3">Nama :</p>
			<p class="mb-3">
				Lokasi :
				<br>

			</p>
			<p class="mb-3">Jenis :</p>
			<p class="mb-3">Harga :</p>
		</div>
		<div class="col-md-7">
			<p class="mb-3">{{ $data->nama_paket }}</p>
			<p class="mb-3">
				{{ $data->outlet->nama }}
				<br>
				<sup class="text-muted">{{ $data->outlet->alamat }}</sup>
			</p>
			<p class="mb-3">{{ $data->jenis->name }}</p>
			<p class="mb-3"><b>{{ $data->harga }}</b></p>
		</div>
	</div> --}}
</div>