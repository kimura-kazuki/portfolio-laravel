<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->masterSeeders();

        $role = [
            'local',
            'testing',
            'development',
            'staging',
        ];

        if (App::environment($role)) {
            $this->testSeeders();
        }
    }

    /**
     * マスタデータのSeeder
     */
    private function masterSeeders()
    {
        $this->call(PrefectureRegionsTableSeeder::class);
        $this->call(PrefecturesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }

    /**
     * テストデータのSeeder
     */
    private function testSeeders()
    {
        $this->call(Test\TestCompaniesTableSeeder::class);
        $this->call(Test\TestUsersTableSeeder::class);
    }
}
