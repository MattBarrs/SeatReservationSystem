<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bookings')->insert([
            'id' => 1,
            'room_name' => 'Example Room',
            'institution_name' => 'Example Institute',
            'seat_name' => 5,
            'start_date' => '2021-07-25',
            'start_time' => '07:00:00',
            'end_time' => '07:59:00',

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);


        DB::table('user_bookings')->insert([
            'id' => 1,
            'user_id' => 1,

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        DB::table('bookings')->insert([
            'id' => 2,
            'room_name' => 'Example Room',
            'institution_name' => 'Example Institute',
            'seat_name' => 12,
            'start_date' => '2021-07-25',
            'start_time' => '07:00:00',
            'end_time' => '07:59:00',

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('user_bookings')->insert([
            'id' => 2,
            'user_id' => 1,

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        DB::table('bookings')->insert([
            'id' => 3,
            'room_name' => 'Example Room',
            'institution_name' => 'Example Institute',
            'seat_name' => 3,
            'start_date' => '2021-07-25',
            'start_time' => '07:00:00',
            'end_time' => '07:59:00',

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('user_bookings')->insert([
            'id' => 3,
            'user_id' => 1,

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
