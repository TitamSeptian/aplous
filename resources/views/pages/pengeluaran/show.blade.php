@include('partials.pcs.function')
<div class="container">
	<table class="mb-3">
		<tr>
			<td width="200">Nama</td>
			<td width="10">:</td>
			<td>{{ $data->nama }}</td>
		</tr>
		<tr>
			<td>Toko</td>
			<td>:</td>
			<td>
				{{ $data->outlet->nama }}
				<br>
				<sup class="text-muted">{{ $data->outlet->alamat }}</sup>
			</td>
		</tr>
		<tr>
			<td>Bulan</td>
			<td>:</td>
			<td>{{ cekBulan($data->bulan) }}</td>
		</tr>
		<tr>
			<td>Harga</td>
			<td>:</td>
			<td><b>{{ $data->harga }}</b></td>
		</tr>
	</table>
</div>