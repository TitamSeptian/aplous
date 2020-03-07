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
        		'nama' => 'Richard Joe',
        		'tlp' => '0812345674',
        		'alamat' => 'Jl. Kacang Kapri Muda Kav. 13',
        		'jenis_kelamin' => 'P',
        	],
        	[
        		'nama' => 'Barry Allen',
        		'tlp' => '081234587',
        		'alamat' => 'Jl. Durian Kapri Muda Kav. 13',
        		'jenis_kelamin' => 'L',
        	],
        	[
        		'nama' => 'Joe West',
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
