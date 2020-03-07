<div class="container">
	<table class="mb-3">
		<tr>
			<td width="200">Nama</td>
			<td width="10">:</td>
			<td>{{ $data->tbUser->nama }}</td>
		</tr>
		<tr>
			<td>Nama Pengguna</td>
			<td>:</td>
			<td>
				{{ $data->username }}
			</td>
		</tr>
		<tr>
			<td>Peran</td>
			<td>:</td>
			<td>
				<b>{{ $data->tbUser->role }}</b>
			</td>
		</tr>
		@if($data->level == 'outlet')
		<tr>
			<td>Outlet</td>
			<td>:</td>
			<td>{{ $data->tbUser->outlet->nama }}</td>
		</tr>
		@endif
	</table>
</div>