<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class tasks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $status = ['View', 'In Progress', 'Done'];
      $users_ids = User::all()->modelKeys();
        for($i = 0; $i < 20; $i++) {
          $statusKey = array_rand($status);
          $users_idsKey = array_rand($users_ids);
          DB::table('tasks')->insert([
             'title' => 'Title '.Str::random(15),
             'description' => 'Decription '.Str::random(15),
             'status' => $status[$statusKey],
             'user_id' => $users_ids[$users_idsKey],
         ]);
        }
    }
}
