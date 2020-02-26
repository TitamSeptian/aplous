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
        // admin
        $admin = User::create([
            'username' => 'admin', 
            'password' => bcrypt('123qwe123'), 
            'level' => 'admin'
        ]);
        // kasir
        $kasir = User::create([
            'username' => 'kasir', 
            'password' => bcrypt('123qwe123'), 
            'level' => 'outlet'
        ]);
        // owner
        $owner = User::create([
            'username' => 'owner', 
            'password' => bcrypt('123qwe123'), 
            'level' => 'outlet'
        ]);

        Admin::create([
            'nama' => 'jhon Admin',
            'user_id' => $admin->id
        ]);

        TbUser::create([
            'nama' => 'Jhon Kasir',
            'username' => $kasir->username,
            'password' => $kasir->password,
            'role' => 'kasir',
            'id_user' => $kasir->id,
            'id_outlet' => 1,
        ]);

        TbUser::create([
            'nama' => 'Jhon owner',
            'username' => $owner->username,
            'password' => $owner->password,
            'role' => 'owner',
            'id_user' => $owner->id,
            'id_outlet' => 1,
        ]);

        // $users = [
        // 	[
        // 		'username' => 'kasir', 
        // 		'password' => bcrypt('123qwe123'), 
        // 		'role' => 'outlet'
        // 	],
        // 	[
        // 		'username' => 'owner', 
        // 		'password' => bcrypt('123qwe123'), 
        // 		'role' => 'outlet'
        // 	],
        // ];

        // $admin = [
        //     [
        //         'username' => 'owner', 
        //         'password' => bcrypt('123qwe123'), 
        //         'role' => 'owner'
        //     ]
        // ];

        // foreach ($users as $data) {
        // 	$user = User::create($data);
        // 	TbUser::create([
        // 		'username' => $user->username, 
        // 		'password' => $user->password, 
        // 		'role' => $user->role, 
        // 		"nama" => 'Jhon '. $user->role, 
        // 		'id_outlet' => 1, 
        // 		'id_user' => $user->id
        // 	]);
        // }
    }
}
