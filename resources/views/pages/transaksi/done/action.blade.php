{{-- <a href="javascript:void(0)" data-title="{{ $model->kode_invoice }}" data-url="{{ $url_transaksi }}" class="badge badge-cyan btn-ts">
	<i class="far fa-money-bill-alt"></i> Transaksi
</a> --}}
<a href="javascript:void(0)" data-title="{{ $model->kode_invoice }}" data-url="{{ $url_show }}" class="badge badge-info btn-show">
	<i class="fas fa-eye"></i> Detail
</a>
{{-- kenapa tidak ada edit 
	karena tidak terlau di butuhkan
 --}}
<a href="javascript:void(0)" data-title="{{ $model->kode_invoice }}" data-url="{{ route('struk.print', $model->id) }}" style="color: #fff" class="badge badge-cyan btn-print">
	<i class="fas fa-print"></i> Print
</a>

<a href="javascript:void(0)" data-title="{{ $model->kode_invoice }}" data-url="{{ $url_delete }}" class="badge badge-danger btn-delete">
	<i class="fas fa-trash"></i> Buang
</a>