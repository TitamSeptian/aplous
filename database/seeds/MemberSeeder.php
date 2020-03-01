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
        members = [
        	[
        		'nama' => 'Richard Joe',
        		'telp' => '0812345674',
        		'alamat' => 'Jl. Kacang Kapri Muda Kav. 13',
        		'jenis_kelamin' => 'P',
        	],
        	[
        		'nama' => 'Barry Allen',
        		'telp' => '081234587',
        		'alamat' => 'Jl. Durian Kapri Muda Kav. 13',
        		'jenis_kelamin' => 'L',
        	],
        	[
        		'nama' => 'Joe West',
        		'telp' => '08123458712',
        		'alamat' => 'Jl. Anggur Kapri Muda Kav. 13',
        		'jenis_kelamin' => 'L',
        	],
        ];

        foreach ($members as $member) {
        	Member::create($member);
        }
    }
}
