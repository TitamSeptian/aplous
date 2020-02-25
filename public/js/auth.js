$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('body').on('submit', '#formLogin', function (e) {
	e.preventDefault();
	$(this).find(':input[type=submit]').prop('disabled', true);
	const url = $(this).attr('action');
	const data = $(this).serializeArray();
	$('#preload').css('display', 'inline');

	$('form').find('.form-group .form-control').removeClass('is-invalid');
	$('span.help-block').remove();

	$.ajax({
		url: url,
		type: 'POST',
		data: data,
		success: (res) => {
			console.log(res)
			setTimeout(() => {
				window.location = '/dashboard';
			}, 1000)
			// setTimeout(() => {
			// 	$('#preload').css('display', 'none');
			// }, 500)
		},
		error: (xhr) => {
			$(this).find(':input[type=submit]').prop('disabled', false);
			$('#preload').css('display', 'none');
			errors = xhr.responseJSON;
			if (xhr.status = 401) {
				if (errors.msg == 'Username tidak valid') {
					$('.form-group input[name=uname]').addClass('is-invalid')
					$('.form-group.uname').append(`<span class="help-block">`+errors.msg+`</span>`);
				} else if (errors.msg == 'Password tidak valid') {
					$('.form-group input[name=pwd]').addClass('is-invalid')
					$('.form-group.pwd').append(`<span class="help-block">`+errors.msg+`</span>`);
				} else {
					console.log(errors.msg)
				}
			}
		}
	})
})