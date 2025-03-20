<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ServiceUser;
use App\Models\ServiceProvider;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->create([
            'name' => 'Event Hub',
            'role' => 1,
            'phone' => '9844906660',
            'email' => 'admin@eventhub.com',
            'password' => Hash::make('password'),
        ]);
    }
}
