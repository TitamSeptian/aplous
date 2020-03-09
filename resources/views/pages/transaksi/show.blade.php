<div class="container">
	<table class="mb-3">
		<tr>
			<td width="200">Kode</td>
			<td width="10">:</td>
			<td><b>{{ $data->kode_invoice }}</b></td>
		</tr>
		<tr>
			<td>Nama Pelanggan</td>
			<td>:</td>
			<td>{{ $data->member->nama }}</td>
		</tr>
		<tr>
			<td colspan="3"><hr></td>
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
			<td>Paket</td>
			<td>:</td>
			<td>
				<table class="table table-sm">
					<thead>
						<tr>
							<th>Nama Paket</th>
							<th>Qty</th>
							<th>Harga</th>
							<th>Sub Total</th>
							<th>Ket</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data->detailTransaksi as $q)
						<tr>
							<td>{{ $q->paket->nama_paket }}</td>
							<td>{{ $q->qty }}</td>
							<td>{{ $q->paket->harga }}</td>
							<td class="text-right">{{ $q->qty * $q->paket->harga }}</td>
							<td>{{ $q->keterangan == null ? '-' : $q->keterangan }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3"><hr></td>
		</tr>
		<tr>
			<td>Status Barang</td>
			<td>:</td>
			<td>{{ $data->status }}</td>
		</tr>
		<tr>
			<td>Pembayaran</td>
			<td>:</td>
			<td>{{ $data->dibayar == 'dibayar' ? 'Dibayar' : 'Belum Dibayar' }}</td>
		</tr>
		<tr>
			<td colspan="3"><hr></td>
		</tr>
		<tr>
			<td>Sub Total</td>
			<td>:</td>
			<td>{{ $a->total }}</td>
		</tr>
		<tr>
			<td>Pajak</td>
			<td>:</td>
			<td>{{ $pajak }}</td>
		</tr>
		<tr>
			<td>Biaya Tambahan</td>
			<td>:</td>
			<td>{{ $data->biaya_tambahan == null ? '0' : $data->biaya_tambahan }}</td>
		</tr>
		<tr>
			<td>Potongan</td>
			<td>:</td>
			<td>{{ $diskon }}</td>
		</tr>
		<tr>
			<td colspan="3"><hr></td>
		</tr>
		<tr>
			<td>Total</td>
			<td>:</td>
			<td><b>{{ $total }}</b></td>
		</tr>
	</table>
</div>