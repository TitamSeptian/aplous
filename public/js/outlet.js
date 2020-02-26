$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// show create
$('body').on('click', '#btn-create', function (e) {
	e.preventDefault();
	const url = $(this).data('url');
	$.ajax({
		url: url,
		dataType: 'html',
		success: (res) => {
			$('#modal-body').html(res)
			$('#modal-title').html("Tambah Outlet")
			$('#modal-lg').modal('show');		
		}
	})
});
// submit store
$('body').on('submit', '#form-store', function (e) {
	e.preventDefault();
	$('.form-group').find('.form-control').removeClass('is-invalid')
	$('form').find('.help-block').remove()
	$(this).find(':input[type=submit]').prop('disabled', true);
	const url = $(this).attr('action');
	const data = $(this).serializeArray();
	$.ajax({
		url: url,
		type: 'POST',
		data: data,
		success: res => {
			$('#tableOutlet').DataTable().ajax.reload();
			Swal.fire({
				title:'Sukses !',
				type:'success',
				text: res.msg,
				showConfirmButton: false,
				timer: 2000
			});
			$('#modal-lg').modal('hide');
		},
		error: xhr => {
			$(this).find(':input[type=submit]').prop('disabled', false);
			if (xhr.status == 500) {
				Swal.fire({
					title:'Aduh !',
					type:'warning',
					text: "Terjadi Kesalahan",
					showConfirmButton: false,
					timer: 2000
				});
			}

			errors = xhr.responseJSON;
			$.each(errors.errors, function (key, value) {
				$('#'+key).closest('.form-group .form-control').addClass('is-invalid')
				$('#' + key).closest('.form-group').append(`<span class="help-block">`+value+`</span>`)
			});
		}
	})
})


// show edit 
$('body').on('click', '.btn-edit', function (e) {
	e.preventDefault();
	$('.form-group').find('.form-control').removeClass('is-invalid')
	$('.form-control').find('.help-block').remove()
	const url = $(this).data('url');
	const title = $(this).data('title');
	$.ajax({
		url: url,
		dataType: 'html',
		success: (res) => {
			$('#modal-body').html(res)
			$('#modal-title').html(title)
			$('#modal-lg').modal('show');
		}
	})
});
// submit edit
$('body').on('submit', '#form-edit', function (e) {
	e.preventDefault();
	$(this).find(':input[type=submit]').prop('disabled', true);
	const url = $(this).attr('action');
	const data = $(this).serializeArray();
	$.ajax({
		url: url,
		type: 'POST',
		data: data,
		success: res => {
			$('#tableOutlet').DataTable().ajax.reload();
			Swal.fire({
				title:'Sukses !',
				type:'success',
				text: res.msg,
				showConfirmButton: false,
				timer: 2000
			});
			$('#modal-lg').modal('hide');
		},
		error: xhr => {
			$(this).find(':input[type=submit]').prop('disabled', false);
			if (xhr.status == 500) {
				Swal.fire({
					title:'Aduh !',
					type:'warning',
					text: "Terjadi Kesalahan",
					showConfirmButton: false,
					timer: 2000
				});
			}

			if (xhr.status == 500) {
				Swal.fire({
					title:'Sukses !',
					type:'warning',
					text: "Terjadi Kesalahan",
					showConfirmButton: false,
					timer: 2000
				});
			}

			errors = xhr.responseJSON;
			$.each(errors.errors, function (key, value) {
				$('#'+key).closest('.form-group .form-control').addClass('is-invalid')
				$('#' + key).closest('.form-group').append(`<span class="help-block">`+value+`</span>`)
			});
		}
	})
});



$('body').on('click', '.btn-show', function (e) {
	e.preventDefault();
	const url = $(this).data('url');
	const title = $(this).data('title');
	$.ajax({
		url: url,
		dataType: 'html',
		success: (res) => {
			$('#modal-body').html(res)
			$('#modal-title').html(title)
			$('#modal-lg').modal('show');
		}
	})
});

$('body').on('click', '.btn-delete', function (e) {
	e.preventDefault();
	const url = $(this).data('url');
	const data = $(this).data('title');

	Swal.fire({
		title:'Anda Yakin ?',
		type:'warning',
		text:data + ' Akan Dihapus Permanen',
		showCancelButton: true,
		confirmButtonColor:'#EF2E2E',
		cancelButtonColor:'#8A8A8A',
		confirmButtonText:'Ya, Hapus !',
		cancelButtonText:'Batal',
	})
	.then(res=>{
		if (res.value) {
			$.ajax({
				url:url,
				type:'POST',
				data: {
					'_method':'DELETE'
				},
				success: function(res){
					$('#myModal').modal('hide');

					Swal.fire({
						title:'Sukses !',
						type:'success',
						text:res.msg,
						showConfirmButton: false,
						timer: 1800
					});

					$('#tableOutlet').DataTable().ajax.reload();
				},

				error: function(xhr){
					const error = xhr.responseJSON;

					Swal.fire({
						title:'Peringatan !',
						type:'warning',
						text:error.msg,
					});
				}
			});
		}
	})
});