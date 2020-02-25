<?php

use Illuminate\Database\Seeder;
use App\User;
use App\TbUser;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
        	[
        		'username' => 'admin', 
        		'password' => bcrypt('123qwe123'), 
        		'role' => 'admin'
        	],
        	[
        		'username' => 'kasir', 
        		'password' => bcrypt('123qwe123'), 
        		'role' => 'kasir'
        	],
        	[
        		'username' => 'owner', 
        		'password' => bcrypt('123qwe123'), 
        		'role' => 'owner'
        	]
        ];

        foreach ($users as $data) {
        	$user = User::create($data);
        	TbUser::create([
        		'username' => $user->username, 
        		'password' => $user->password, 
        		'role' => $user->role, 
        		"nama" => 'Jhon '. $user->role, 
        		'id_outlet' => 1, 
        		'id_user' => $user->id
        	]);
        }
    }
}
