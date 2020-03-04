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
        		'name' => 'Selimut', 
        		'ket' => 'Selimut'
        	],
        	[
        		'name' => 'Bed Cover', 
        		'ket' => 'Bed Cover'
        	],
        	[
        		'name' => 'Kaos', 
        		'ket' => 'Kaos'
        	],
        ];

        foreach ($jenis as $a) {
        	Jenis::create($a);
        }
    }
}
