<?php

use Illuminate\Database\Seeder;
use App\User;
use App\TbUser;
use App\Outlet;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $outlet = Outlet::first();
        $users = [
            [
                'username' => 'admin', 
                'password' => bcrypt('123qwe123'), 
                'level' => 'admin'
            ],
            [
                'username' => 'kasir', 
                'password' => bcrypt('123qwe123'), 
                'level' => 'kasir'
            ],
                [
                'username' => 'owner', 
                'password' => bcrypt('123qwe123'), 
                'level' => 'owner'
            ]
        ];

        foreach ($users as $data) {
        	$user = User::create($data);
        	TbUser::create([
        		// 'username' => $user->username, 
        		// 'password' => $user->password, 
        		'role' => $user->level, 
        		"nama" => 'Jhon '. $user->level, 
        		'id_outlet' => $outlet->id, 
        		'id_user' => $user->id
        	]);
        }
    }
}
