<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SystemCountrySeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(VariableSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(SystemRouteSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MeetingSeeder::class);
        $this->call(MeetingHallSeeder::class);
        $this->call(ParticipantSeeder::class);
        $this->call(ProgramSeeder::class);
    }
}
