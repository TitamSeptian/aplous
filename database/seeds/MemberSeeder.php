<?php

use Illuminate\Database\Seeder;
use App\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = [
        	[
        		'nama' => 'Rahma dewi',
        		'tlp' => '08123456744',
        		'alamat' => 'Jl. Kacang Kapri Muda Kav. 13',
        		'jenis_kelamin' => 'P',
        	],
        	[
        		'nama' => 'Yomi Adlan',
        		'tlp' => '081234581',
        		'alamat' => 'Jl. Durian Kapri Muda Kav. 13',
        		'jenis_kelamin' => 'L',
        	],
        	[
        		'nama' => 'Saputra Kurnia',
        		'tlp' => '08123458712',
        		'alamat' => 'Jl. Anggur Kapri Muda Kav. 13',
        		'jenis_kelamin' => 'L',
        	],
        ];

        foreach ($members as $member) {
        	Member::create($member);
        }

        foreach ($members as $member) {
        }
    }
}
