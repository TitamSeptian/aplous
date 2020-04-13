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
</div>