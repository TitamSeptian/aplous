$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// when click button delete will be delete spesifik data form storage using softDeelet
$("body").on("click", ".btn-delete", function (e) {
    e.preventDefault();
    const url = $(this).data("url");
    Swal.fire({
        title: "Anda Yakin ?",
        type: "warning",
        text: "Riwayat Akan di Hapus Permanen",
        showCancelButton: true,
        confirmButtonColor: "#ff4f70",
        cancelButtonColor: "#8A8A8A",
        confirmButtonText: "Ya, Hapus !",
        cancelButtonText: "Batal",
    }).then((res) => {
        if (res.value) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _method: "DELETE",
                },
                success: function (res) {
                    $("#myModal").modal("hide");

                    Swal.fire({
                        title: "Sukses !",
                        type: "success",
                        text: res.msg,
                        showConfirmButton: true,
                        timer: 1800,
                    });

                    $("#tableLog").DataTable().ajax.reload();
                },

                error: function (xhr) {
                    const errors = xhr.responseJSON;

                    Swal.fire({
                        title: "Peringatan !",
                        type: "warning",
                        text: errors.msg,
                    });
                },
            });
        }
    });
});

$("body").on("click", ".btn-delete-all", function (e) {
    let empty = $("#tableLog tbody").find(".dataTables_empty");
    e.preventDefault();
    const url = $(this).data("url");
    if (empty.length == 0) {
        Swal.fire({
            title: "Anda Yakin ?",
            type: "warning",
            text: "Akan Dihapus Semua",
            showCancelButton: true,
            confirmButtonColor: "#ff4f70;",
            cancelButtonColor: "#8A8A8A",
            confirmButtonText: "Ya, Hapus !",
            cancelButtonText: "Batal",
        }).then((res) => {
            if (res.value) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {},
                    success: function (res) {
                        $("#myModal").modal("hide");

                        Swal.fire({
                            title: "Sukses !",
                            type: "success",
                            text: res.msg,
                            showConfirmButton: true,
                            timer: 1800,
                        });

                        $("#tableLog").DataTable().ajax.reload();
                    },

                    error: function (xhr) {
                        const error = xhr.responseJSON;

                        Swal.fire({
                            title: "Peringatan !",
                            type: "warning",
                            text: error.msg,
                        });
                    },
                });
            }
        });
    } else {
        Swal.fire({
            title: "Peringatan !",
            type: "warning",
            text: "Data Kosong",
        });
    }
});

$("body").on("click", ".btn-refresh", function (e) {
    $("#tableLog").DataTable().ajax.reload();
});
