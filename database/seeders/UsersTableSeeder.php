<?php
/**
 * @copyright   Knowledge Software. All Rights Reserved.
 * @since       2021/06/24
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\RoleType;
use App\Enums\Sex;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @todo Change company default id
     * @return void
     */
    public function run()
    {
        // マスターデータとして登録
        User::create([
            // 'membership_number' => \Sequence::getNewUserNo('system admin'),
            'name' => '木村 一樹',
            'name_kana' => 'キムラ カズキ',
            'email' => 'kidsc0me@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('1234qwer'),
            'sex_code' => Sex::Male,
            'role' => UserRole::SystemAdmin->value,
            // 'role' => RoleType::SystemAdmin()->key,
            // 'is_approved' => IsApproved::Approved,
            'created_by' => 1,
        ])->assignRole('system admin');
    }
}
