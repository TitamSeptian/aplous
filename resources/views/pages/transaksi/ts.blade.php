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
            <td colspan="3">
                <hr>
            </td>
        </tr>
        <tr>
            <td>Status Barang</td>
            <td>:</td>
            <td>
                {{-- <form action="{{ route('transaksi.status', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT') --}}
                    <input type="hidden" name="url" id="url" value="{{ route('transaksi.status', $data->id) }}">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" name="status" value="baru" id="baru" class="custom-control-input status" {{ $data->status == 'baru' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="baru">Baru</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" name="status" value="proses" id="proses" class="custom-control-input status" {{ $data->status == 'proses' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="proses">Proses</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" name="status" value="selesai" id="selesai" class="custom-control-input status" {{ $data->status == 'selesai' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="selesai">Selesai</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" name="status" value="diambil" id="diambil" class="custom-control-input status" {{ $data->status == 'diambil' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="diambil">Diambil</label>
                    </div>
                {{-- </form> --}}
            </td>
        </tr>
        <tr>
            <td>Pembayaran</td>
            <td>:</td>
            <td>{{ $data->dibayar == 'dibayar' ? 'Dibayar' : 'Belum Dibayar' }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <hr>
            </td>
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
            <td>{{ $diskon == null ? '0' : $data->diskon }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <hr>
            </td>
        </tr>
        <tr>
            <td>Total</td>
            <td>:</td>
            <td><b>{{ $total }}</b></td>
        </tr>
    </table>
</div>