<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(OutletSeeder::class);
        $this->call(JenisSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(PaketSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TransaksiSeeder::class);
    }
}
