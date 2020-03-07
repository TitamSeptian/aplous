<?php

use Illuminate\Database\Seeder;
use App\Jenis;
use App\Outlet;
use App\Paket;


class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$jenis = Jenis::take(3)->get();
    	$outlet = Outlet::first();
    	$pakets = [
    		[
    			'nama_paket' => 'kiloan',
    			'harga' => 7000,
    		],
    		[
    			'nama_paket' => 'bed cover',
    			'harga' => 30000,
    		],
    		[
    			'nama_paket' => 'Selimut',
    			'harga' => 15000,
    		],
    	];

    	foreach ($pakets as $key => $p) {
    		Paket::create([
    			'nama_paket' => $p['nama_paket'],
    			'harga' => $p['harga'],
    			'id_jenis' => $jenis[$key]->id,
    			'id_outlet' => $outlet->id,
    		]);
    	}
    }
}
