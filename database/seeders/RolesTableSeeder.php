<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/08/25
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRole;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
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
        Role::create(['name' => 'system admin', 'description' => 'システム管理者']);
        Role::create(['name' => 'admin', 'description' => '運営者']);
        Role::create(['name' => 'staff', 'description' => 'スタッフ']);
    }
}
