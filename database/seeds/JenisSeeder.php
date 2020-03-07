<?php

use Illuminate\Database\Seeder;
use App\Jenis;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis = [
        	[
        		'name' => 'Kiloan', 
        		'ket' => 'Baju kiloan'
        	],
        	[
        		'name' => 'Selimut (M)', 
        		'ket' => 'Selimut kecil'
        	],
        	[
        		'name' => 'Bed Cover', 
        		'ket' => 'Bed Cover'
        	],
        ];

        foreach ($jenis as $a) {
        	Jenis::create($a);
        }
    }
}
