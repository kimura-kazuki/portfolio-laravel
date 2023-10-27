<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/02/25
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use App\Models\LineAccount;
use App\Enums\UserRole;
use App\Enums\Sex;

class TestUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 運営者
        User::factory()
            ->admin()
            ->create([
                // 'membership_number' => \Sequence::getNewUserNo('system admin'),
                'name' => '運営者',
                'name_kana' => 'ウンエイシャ',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'sex_code' => Sex::Male,
                'role' => UserRole::Admin->value,
                // 'role' => RoleType::SystemAdmin()->key,
                // 'is_approved' => IsApproved::Approved,
                'created_by' => 1,
            ])
        ;
        // スタッフ
        User::factory()
            ->staff()
            ->create([
                // 'membership_number' => \Sequence::getNewUserNo('system admin'),
                'name' => 'スタッフ',
                'name_kana' => 'スタッフ',
                'email' => 'staff@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'sex_code' => Sex::Male,
                'role' => UserRole::Staff->value,
                // 'role' => RoleType::SystemAdmin()->key,
                // 'is_approved' => IsApproved::Approved,
                'created_by' => 1,
            ])
        ;

        /**
         * ランダムアカウント
         */

        // Admin user
        User::factory(10)
            ->admin()
            ->create()
        ;

        // Staff user
        User::factory(10)
            ->staff()
            ->create()
        ;
    }
}
