<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Administrator",
            'email' => "PleaseChangeThis@gmail.com",
            'current_team_id' => 1,
            'password' => Hash::make('PleaseChange'),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);
        DB::table('teams')->insert([
            'id' => 1,
            'user_id' => 1,
            'name' => 'Local Admins',
            'personal_team' => 1,

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
