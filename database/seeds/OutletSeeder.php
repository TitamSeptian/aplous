<?php

use Illuminate\Database\Seeder;
use App\Outlet;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $outlets = [
        	[
        		'nama' => 'Toko Aplous Pusat', 
        		'alamat' => 'Jalan Siliwangi 27 RT 07 RW 18 Kelurahan Kalijati Kecamatan Bumi Indah Kota Bandung Jawa Barat  45132', 
        		'tlp' => '082548367835'
        	],
        	[
        		'nama' => 'Toko Aplous Cabang 2', 
        		'alamat' => ' Jalan Batu Tulis No. 05 Kota Bandung Jawa Barat 1456', 
        		'tlp' => '089638258256'
        	],
        	[
        		'nama' => 'Toko Aplous Cabang 3', 
        		'alamat' => 'Jalan Arief Rahman Hakin 35 41212 Subang Jawa Barat', 
        		'tlp' => '085493427351'
        	],
        ];

        foreach ($outlets as $outlet) {
        	Outlet::create($outlet);
        }
    }
}
