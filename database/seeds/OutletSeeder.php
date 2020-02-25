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
        		'nama' => 'Aplous Cabang 1', 
        		'alamat' => 'Subang 1', 
        		'tlp' => '0811101810'
        	],
        	[
        		'nama' => 'Aplous Cabang 2', 
        		'alamat' => 'Subang 2', 
        		'tlp' => '0811101810'
        	],
        	[
        		'nama' => 'Aplous Cabang 2', 
        		'alamat' => 'Subang 3', 
        		'tlp' => '0811101810'
        	],
        ];

        foreach ($outlets as $outlet) {
        	Outlet::create($outlet);
        }
    }
}
