<?php

use Illuminate\Database\Seeder;
use App\User;
use App\TbUser;
use App\Admin;

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
                'level' => 'admin'
            ],
            [
                'username' => 'kasir', 
                'password' => bcrypt('123qwe123'), 
                'level' => 'outlet'
            ],
                [
                'username' => 'owner', 
                'password' => bcrypt('123qwe123'), 
                'level' => 'outlet'
            ]
        ]

        foreach ($users as $data) {
        	$user = User::create($data);
        	TbUser::create([
        		'username' => $user->username, 
        		'password' => $user->password, 
        		'role' => $user->role, 
        		"nama" => 'Jhon '. $user->role, 
        		'id_outlet' => $user->role == 'admin' ? '' : $user->role, 
        		'id_user' => $user->id
        	]);
        }
    }
}
