<?php

use Illuminate\Database\Seeder;
use App\TbUser;
use App\DetailTransaksi;
use App\Transaksi;
use App\Outlet;
use App\Paket;
use App\Member;


class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $outlet = Outlet::first();
        $paket = Paket::take(3)->get();
        $member = Member::first();
        $user = TbUser::first();
        $transaksi = [
			"id_outlet" => $outlet->id,
			"kode_invoice" => 'APL20041721410011',
			"id_member" => $member->id,
			"tgl" => "2020-04-16 08:50:35",
			"batas_waktu" => "2020-04-17 08:50:35",
			"tgl_bayar" => null,
			"biaya_tambahan" => 5000,
			"diskon" => 3, //%,
			"pajak" => 10, //%
			"status" => 'baru',
			'dibayar' => 'belum_dibayar',
			"id_user" => $user->id,
        ];
        $ts = Transaksi::create($transaksi);
        foreach ($paket as $key => $p) {
        	DetailTransaksi::create([
        		'id_transaksi' => $ts->id,
        		'id_paket' => $p['id'],
        		'qty' => 2,
         	]);	
        }
    }
}
