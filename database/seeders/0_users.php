<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for($i = 0; $i < 10; $i++) {
        $int= mt_rand(1162055681,1362055681);
        DB::table('users')->insert([
           'first_name' => 'UserName '.Str::random(5),
           'last_name' => 'UserLast '.Str::random(5),
           'email' => 'user'.Str::random(10).'@gmail.com',
           'password' => Hash::make('test'),
           'created_at' => date("Y-m-d H:i:s",$int)
       ]);
      }
    }
}
