$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
const paket = $('#paket');
const outlet = $('#outlet');
const tambah = $('#tambah');
const member = $('#member');
const diskon = $('#diskon');
const biaya_tambahan = $('#biaya_tambahan');
const qty = $('#qty');
const tbody = $('#tbody');
window.onload = init();

function init() {
    paket.val('');
    diskon.val('');
    biaya_tambahan.val('');
}

// click slected paket
$('body').on('click', '.p-paket', function(e) {
    e.preventDefault();
    let id = $(this).attr('data-s-id');
    let nama = $(this).attr('data-s-nama');
    let data_harga = $(this).attr('data-harga');
    $('#paket').val(nama);
    // paket.attr('data-paket-id', id)
    $('#paket-id').val(id);
    paket.attr('data-harga', data_harga)
    $('#modalPaket').modal('hide');
});

$('body').on('click', '#tambah', function(e) {
    e.preventDefault();
    if ($('#paket-id').val() == '') {
        Swal.fire({
            title: 'Peringatan !',
            type: 'warning',
            text: "Pilih Paket",
        });
    } else if (qty.val() == '') {
        Swal.fire({
            title: 'Peringatan !',
            type: 'warning',
            text: "Masukan Quantitas",
        });
    } else{   
        toTable();
    }
});

i = 1;

function toTable() {
    // let dataOutlet = outlet.val();
    // let dataMember = member.val();
    // let dataPaket = paket.val();
    // let dataQty = qty.val();
    // let dataDiskon = diskon.val();
    let paketId = $('#paket-id').val();
    let harga = parseInt(paket.attr('data-harga'));
    // console.log(harga.toFixed(2))
    let there = $(`[data-paket-id=${paketId}]`);
    if (there.length != 0) {
        let thereQty = there.find('.qty').val();
        let ress = parseFloat(thereQty) + parseFloat(qty.val());
        there.find('.qty').val(ress);
        there.find('.harga').val(ress * parseInt(harga))
    } else {
        tbody.prepend(` 
			<tr data-paket-id="${paketId}">
	            <input type="hidden" name="p_id[]" value="${paketId}">
	            <input type="hidden" name="res_harga[]" class="res_harga" value="${harga}">
	            <td>${i++}</td>
	            <td>
	                <input type="text" name="nama_paket[]" autocomplete="off" class="cl-line nama_paket" value="${paket.val()}" readonly>
	            </td>
	            <td>
	                <input type="text" name="qty[]" autocomplete="off" class="grey-line qty" value="${qty.val()}">
	            </td>
	            <td>
	                <input type="text" name="harga[]" class="cl-line harga" value="${(parseFloat(qty.val()) * parseInt(harga)).toFixed(1)}" readonly>
	            </td>
	            <td>
	                <textarea class="grey-line ket" name="ket" autocomplete="off" style="width: 100%;"></textarea>
	            </td>
	            <td>
	                <a href="javascript:void(0)" class="rmv"><i class="fa fa-times text-danger"></i></a>
	            </td>
	        </tr>
		`);
    }
    qty.val('')
    paket.val('')
    total();
    brg();
}

function total() {
    let sub_total = 0;
    $('.harga').each(function(i, e) {
        var sub = $(this).val() - 0;
        sub_total += sub;
    });
    let rp_subTotal = formatRupiah(sub_total.toString(), '');
    $('#subtot').html(` 
		Sub Total : ${rp_subTotal}`)
}

function brg() {
    let me = $('#tbody tr').length
    $('#jml-barang').html(`Jumlah Barang ${me}`)
}

// // remove view table
$('body').on('click', '.rmv', function(e) {
    e.preventDefault();
    $(this).parent().parent().remove();
    brg();
    total();
});

$('body').on('change', '.qty', function() {
    let qty = $(this).val();
    if (qty == '' || qty == '0') {
        Swal.fire({
            title: 'Peringatan !',
            type: 'warning',
            text: "Qty Tidak Valid",
        });
    } else {
        let price = $(this).parent().parent().find('.res_harga').val()
        $(this).parent().parent().find('.harga').val(parseFloat(qty) * parseFloat(price));
        total();
    }
})

$('body').on('click', '#btn-pesan', function(e) {
    let there = $('#tbody tr').length
    $('.form-group').find('.form-control').removeClass('is-invalid')
    $('form').find('.help-block').remove()
    if (there == 0) {
        Swal.fire({
            title: 'Peringatan !',
            type: 'warning',
            text: "Tidak Ada Paket",
        });
    } else {
        $('#form-transaksi').submit();
    }
    // let paketId = $('#paket-id').val();
    // let there = $(`[data-paket-id=${paketId}]`);
});

$('body').on('submit', '#form-transaksi', function(e) {
    e.preventDefault();
    $(this).find(':input[type=submit]').prop('disabled', true);
    const url = $(this).attr('action');
    const data = $(this).serializeArray();
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: res => {
            window.open(res.url, '_blank')
            window.location.href = res.back;
            // Swal.fire({
            // 	title:'Sukses !',
            // 	type:'success',
            // 	text: res.msg,
            // 	showConfirmButton: false,
            // 	timer: 2000
            // });
            // $('#modal-lg').modal('hide');
        },
        error: xhr => {
            $(this).find(':input[type=submit]').prop('disabled', false);
            errors = xhr.responseJSON;
            if (xhr.status == 500) {
                Swal.fire({
                    title: 'Aduh !',
                    type: 'warning',
                    text: "Terjadi Kesalahan",
                    showConfirmButton: false,
                    timer: 2000
                });
            }

            if (xhr.status == 401) {
                Swal.fire({
                    title: 'Aduh !',
                    type: 'warning',
                    text: errors.msg,
                    showConfirmButton: false,
                    timer: 2000
                });
            }

            if (xhr.status == 422) {
                $.each(errors.errors, function(key, value) {
                    if (key == 'hd_outlet') {
                        Swal.fire({
                            title: 'Aduh !',
                            type: 'warning',
                            text: 'Pilih Outlet',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }

                    if (key == 'member') {
                        Swal.fire({
                            title: 'Aduh !',
                            type: 'warning',
                            text: 'Pilih Pelanggan',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                    $('#' + key).closest('.form-group .form-control').addClass('is-invalid')
                    $('#' + key).closest('.form-group').append(`<span class="help-block text-danger">` + value + `</span>`)
                });
            }
        }
    })
});

$('body').on('click', '#fresh', function() {
    outlet.prop("disabled", false);
    tbody.html('');
    total();
    brg();
});

$('body').on('click', '.btn-refresh', function(e) {
    e.preventDefault();
    $('#tableTransaksi').DataTable().ajax.reload();
});


$('body').on('click', '.btn-show', function(e) {
    e.preventDefault();
    const url = $(this).data('url');
    const title = $(this).data('title');
    $.ajax({
        url: url,
        dataType: 'html',
        success: (res) => {
            $('#modal-body').html(res)
            $('#modal-title').html("Paket " + title)
            $('#modal-lg').modal('show');
        }
    })
    // $('#tableTransaksi').DataTable().ajax.reload();
});

$('body').on('click', '.btn-ts', function(e) {
    e.preventDefault();
    const url = $(this).data('url');
    const title = $(this).data('title');
    $.ajax({
        url: url,
        dataType: 'html',
        success: (res) => {
            $('#modal-body').html(res)
            $('#modal-title').html("Paket " + title)
            $('#modal-lg').modal('show');
        }
    })
    // $('#tableTransaksi').DataTable().ajax.reload();
});

//click radio button status on transaksi
$('body').on('click', '.status', function(e) {
    let v = $(this).val();
    let url = $('#url').val();
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _method: 'PUT',
            status: v,
        },
        success: res => {
            console.log('success')
        },
        error: xhr => {
            // $(this).find(':input[type=submit]').prop('disabled', false);
            errors = xhr.responseJSON;
            if (xhr.status == 500) {
                Swal.fire({
                    title: 'Aduh !',
                    type: 'warning',
                    text: "Terjadi Kesalahan",
                    showConfirmButton: false,
                    timer: 2000
                });
            }

            if (xhr.status == 401) {
                Swal.fire({
                    title: 'Aduh !',
                    type: 'warning',
                    text: errors.msg,
                    showConfirmButton: false,
                    timer: 2000
                });
            }

        }
    })
});

$('body').on('submit', '#form-bayar', function(e) {
    e.preventDefault();
    const bayar = parseInt($('#bayar').val())
    const total = parseInt($('#total-ts').html())
    const url = $(this).attr('action');
    const data = $(this).serializeArray();
    $(this).find(':input[type=submit]').prop('disabled', true);
    if (bayar < total) {
        $(this).find(':input[type=submit]').prop('disabled', false);
        Swal.fire({
            title: 'Aduh !',
            type: 'warning',
            text: "Uang Kurang",
            showConfirmButton: false,
            timer: 2000
        });
    } else {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: res => {
                $('#modal-lg').modal('hide');
                window.open(res.url, '_blank')
                window.location.href = res.back;
            },
            error: xhr => {
                // $(this).find(':input[type=submit]').prop('disabled', false);
                errors = xhr.responseJSON;
                if (xhr.status == 500) {
                    Swal.fire({
                        title: 'Aduh !',
                        type: 'warning',
                        text: "Terjadi Kesalahan",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }

                if (xhr.status == 401) {
                    Swal.fire({
                        title: 'Aduh !',
                        type: 'warning',
                        text: errors.msg,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }

            }
        })
    }
})


//when modal cloes/hide event
$("#modal-lg").on('hidden.bs.modal', function() {
    $('#tableTransaksi').DataTable().ajax.reload();
});

$('body').on('click', '.btn-delete', function(e) {
    e.preventDefault();
    const url = $(this).data('url');
    // const data = $(this).data('title');

    Swal.fire({
            title: 'Anda Yakin ?',
            type: 'warning',
            text: 'Transaksi Akan Dibuang',
            showCancelButton: true,
            confirmButtonColor: '#ff4f70',
            cancelButtonColor: '#8A8A8A',
            confirmButtonText: 'Ya, Buang !',
            cancelButtonText: 'Batal',
        })
        .then(res => {
            if (res.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_method': 'DELETE'
                    },
                    success: function(res) {
                        $('#myModal').modal('hide');

                        Swal.fire({
                            title: 'Sukses !',
                            type: 'success',
                            text: res.msg,
                            showConfirmButton: false,
                            timer: 1800
                        });

                        $('#tableTransaksi').DataTable().ajax.reload();
                    },

                    error: function(xhr) {
                        const errors = xhr.responseJSON;

                        Swal.fire({
                            title: 'Peringatan !',
                            type: 'warning',
                            text: errors.msg,
                        });
                    }
                });
            }
        })
});


// =====================================================================================



// when click button delete will be returned spesifik data  form storage using softDeelet
$('body').on('click', '.btn-restore', function(e) {
    e.preventDefault();
    const url = $(this).data('url');
    const data = $(this).data('title');

    Swal.fire({
            title: 'Anda Yakin ?',
            type: 'warning',
            text: data + ' Akan Dikembalikan',
            showCancelButton: true,
            confirmButtonColor: '##5f76e8;',
            cancelButtonColor: '#8A8A8A',
            confirmButtonText: 'Ya, Kembalikan !',
            cancelButtonText: 'Batal',
        })
        .then(res => {
            if (res.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {},
                    success: function(res) {
                        $('#myModal').modal('hide');

                        Swal.fire({
                            title: 'Sukses !',
                            type: 'success',
                            text: res.msg,
                            showConfirmButton: false,
                            timer: 1800
                        });

                        $('#tableTransaksi').DataTable().ajax.reload();
                    },

                    error: function(xhr) {
                        const error = xhr.responseJSON;

                        Swal.fire({
                            title: 'Peringatan !',
                            type: 'warning',
                            text: error.msg,
                        });
                    }
                });
            }
        })
});

// when click button delete will be returned spesifik data  form storage PERMANENT
$('body').on('click', '.btn-force-delete', function(e) {
    e.preventDefault();
    const url = $(this).data('url');
    const data = $(this).data('title');

    Swal.fire({
            title: 'Anda Yakin ?',
            type: 'warning',
            text: data + ' Akan Dihapus Permanen',
            showCancelButton: true,
            confirmButtonColor: '#EF2E2E',
            cancelButtonColor: '#8A8A8A',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Batal',
        })
        .then(res => {
            if (res.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_method': 'DELETE'
                    },
                    success: function(res) {
                        $('#myModal').modal('hide');

                        Swal.fire({
                            title: 'Sukses !',
                            type: 'success',
                            text: res.msg,
                            showConfirmButton: false,
                            timer: 1800
                        });

                        $('#tableTransaksi').DataTable().ajax.reload();
                    },

                    error: function(xhr) {
                        const error = xhr.responseJSON;

                        Swal.fire({
                            title: 'Peringatan !',
                            type: 'warning',
                            text: error.msg,
                        });
                    }
                });
            }
        })
});

// restore all data
$('body').on('click', '.btn-restore-all-outlet', function(e) {
    let empty = $('#tableTransaksi tbody').find('.dataTables_empty');
    e.preventDefault();
    const url = $(this).data('url');
    if (empty.length == 0) {
        Swal.fire({
                title: 'Anda Yakin ?',
                type: 'warning',
                text: 'Akan Dikembalikan Semua',
                showCancelButton: true,
                confirmButtonColor: '##5f76e8;',
                cancelButtonColor: '#8A8A8A',
                confirmButtonText: 'Ya, Kembalikan !',
                cancelButtonText: 'Batal',
            })
            .then(res => {
                if (res.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {},
                        success: function(res) {
                            $('#myModal').modal('hide');

                            Swal.fire({
                                title: 'Sukses !',
                                type: 'success',
                                text: res.msg,
                                showConfirmButton: false,
                                timer: 1800
                            });

                            $('#tableTransaksi').DataTable().ajax.reload();
                        },

                        error: function(xhr) {
                            const error = xhr.responseJSON;

                            Swal.fire({
                                title: 'Peringatan !',
                                type: 'warning',
                                text: error.msg,
                            });
                        }
                    });
                }
            })
    } else {
        Swal.fire({
            title: 'Peringatan !',
            type: 'warning',
            text: "Data Kosong",
        });
    }
})

// delete all data
$('body').on('click', '.btn-delete-all-outlet', function(e) {
    e.preventDefault();
    const url = $(this).data('url');
    let empty = $('#tableTransaksi tbody').find('.dataTables_empty');
    if (empty.length == 0) {
        Swal.fire({
                title: 'Anda Yakin ?',
                type: 'warning',
                text: 'Akan Dihapus Semua',
                showCancelButton: true,
                confirmButtonColor: '##5f76e8;',
                cancelButtonColor: '#8A8A8A',
                confirmButtonText: 'Ya, Kembalikan !',
                cancelButtonText: 'Batal',
            })
            .then(res => {
                if (res.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE'
                        },
                        success: function(res) {
                            $('#myModal').modal('hide');

                            Swal.fire({
                                title: 'Sukses !',
                                type: 'success',
                                text: res.msg,
                                showConfirmButton: false,
                                timer: 1800
                            });

                            $('#tableTransaksi').DataTable().ajax.reload();
                        },

                        error: function(xhr) {
                            const error = xhr.responseJSON;

                            Swal.fire({
                                title: 'Peringatan !',
                                type: 'warning',
                                text: error.msg,
                            });
                        }
                    });
                }
            })
    } else {
        Swal.fire({
            title: 'Peringatan !',
            type: 'warning',
            text: "Data Kosong",
        });
    }
});


$('body').on('click', '.btn-print', function(e) {
    e.preventDefault();
    const url = $(this).data('url');
    const title = $(this).data('title');
    Swal.fire({
            title: 'Anda Yakin ?',
            type: 'warning',
            text: `Akan Membuat Struk ${title} ?`,
            showCancelButton: true,
            confirmButtonColor: '#5f76e8;',
            cancelButtonColor: '#8A8A8A',
            confirmButtonText: 'Ya, Buat !',
            cancelButtonText: 'Batal',
        })
        .then(res => {
            if (res.value) {
                window.open(url, '_blank')
                // window.location.href = res.back;
            }
        })
});

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}


setInterval(() => {
    $('#hd_outlet').val(outlet.val())
    $('#hd_member').val($("#member").val())
}, 300)
