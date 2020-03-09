<html>

<head>
    <title>Kwitansi</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet"> -->
    <style type="text/css">
    .lead {
        font-family: "Verdana";
        font-weight: bold;
    }

    .value {
        font-family: "Verdana";
    }

    .value-big {
        font-family: "Verdana";
        font-weight: bold;
        font-size: large;
    }

    .td {
        valign: "top";
    }

    /* @page { size: with x height */
    /*@page { size: 20cm 10cm; margin: 0px; }*/
    @page {
        size: A4;
        margin: 0px;
    }

    * {
        font-size: 12px;
    }

    .warp {
        padding: 10px;
        max-width: 400px;
        width: auto;
        border: 1px solid black;
    }


    /*file:///C:/laragon/www/playground/Web%20Design/kwitansi/index.html*/
    </style>
    <script type="text/javascript">
    var beforePrint = function() {
        // alert("message?: DOMString");
        console.log('asaslalsk')
    };

    var afterPrint = function() {
        window.close();
    };

    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                beforePrint();
            } else {
                afterPrint();
            }
        });
    }

    window.onbeforeprint = beforePrint;
    window.onafterprint = afterPrint;
    </script>
</head>

<body>
    <div class="warp">
        <table>
            <tbody>
                <tr class="text-center">
                    <td colspan="3">
                        <img src="{{ asset ('img/rsz_1aplous-logo.png') }}">
                        <h3>@yield('nama_outlet')</h3>
                        <p>@yield('alamat_outlet')</p>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Masuk</td>
                    <td colspan="2" class="text-right">@yield('tanggal_masuk')</td>
                </tr>
                <tr>
                    <td>Estimasi Selesai</td>
                    <td colspan="2" class="text-right">@yield('estimasi')</td>
                </tr>
                <tr>
                    <td>Petugas</td>
                    <td colspan="2" class="text-right">@yield('petugas')</td>
                </tr>
                <tr>
                    <td>Nama Pelanggan</td>
                    <td colspan="2" class="text-right">@yield('pelanggan')</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <hr class="ml-3 mr-3">
                    </td>
                </tr>
                <tr>
                    <td><b>Nama Barang</b></td>
                    <td class="text-center"><b>Quantitas</b></td>
                    <td class="text-right"><b>Harga</b></td>
                </tr>
                @yield('list')
                <td colspan="3" height="50px"></td>
                <tr>
                    <td colspan="2" class="text-right">Sub Total</td>
                    <td class="text-right" id="sub-total"></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">Pajak</td>
                    <td class="text-right" id="pajak"></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">Biaya Tambah</td>
                    <td class="text-right" id="biaya-tambah">@yield('biaya_tambah')</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">Potongan</td>
                    <td class="text-right" id="diskon"></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">Total</td>
                    <td class="text-right" id="total"></td>
                </tr>
                @yield('struk')
                <tr>
                    <td colspan="3" class="text-center">
                        <hr class="ml-3 mr-3">
                        <span>@yield('kode_invoice')</span>
                        <p style="padding: 25px;">
                            Terima Kasih Atas Kunjungan Anda Segala kerusakan diluar tanggung jawab kami. Jika dalam waktu 2 bulan tidak ada kabar segala kerusakan pada barang diluar tanggunf jawab kami.
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script type="text/javascript">
        function totalItem() {
            let hargaIni = 0;
            $('.item').each(function(i, e) {
                var qty = $(this).find('td.qty').html();
                var harga = $(this).find('.harga').html();
                $(this).find('td.harga-tot').html(parseFloat(qty) * parseFloat(harga))
            });
            // $('#subtot').html(` 
            //     Sub Total ${hargaIni}`)
        }

        function subTotal() {
            let sub_total = 0;
            $('.harga-tot').each(function(i,e) {
                let tot = parseFloat($(this).html());
                sub_total += tot;
            });
            $('#sub-total').html(sub_total);
        }

        function total() {
            let dataPajak = parseInt($('#pajakVal').val());
            let dataDiskon = parseInt($('#diskonVal').val());
            let dataSub = parseInt($('#sub-total').html());
            let pajak = dataPajak/100 * dataSub;
            let diskon = dataDiskon/100 *dataSub;
            $('#pajak').html(pajak)
            $('#diskon').html(diskon)
            let res = pajak + dataSub + parseInt($('#biaya-tambah').html()) - diskon;
            $('#total').html(res);
        }

        function kembalian() {
            let total = parseInt($('#total').html())
            let bayar = parseInt($('#bayar').html())
            console.log(total);
            console.log(bayar)
            $('#kembalian').html(bayar - total);

        }

    $(document).ready(function() {
        totalItem();
        subTotal();
        total();
        kembalian();
        window.print();
    });
    </script>
</body>