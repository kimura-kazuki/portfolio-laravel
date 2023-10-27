<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/01/24
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\PrefectureRegion;
use Spatie\Permission\Models\Role;

class PrefectureRegionsTableSeeder extends Seeder
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
        PrefectureRegion::create(['id' => 1, 'name' => '北海道地方', 'name_kana' => 'ホッカイドウ']);
        PrefectureRegion::create(['id' => 2, 'name' => '東北地方', 'name_kana' => 'トウホクチホウ']);
        PrefectureRegion::create(['id' => 3, 'name' => '関東地方', 'name_kana' => 'カントウチホウ']);
        PrefectureRegion::create(['id' => 4, 'name' => '中部地方', 'name_kana' => 'チュウブチホウ']);
        PrefectureRegion::create(['id' => 5, 'name' => '近畿地方', 'name_kana' => 'キンキチホウ']);
        PrefectureRegion::create(['id' => 6, 'name' => '中国地方', 'name_kana' => 'チュウゴクチホウ']);
        PrefectureRegion::create(['id' => 7, 'name' => '四国地方', 'name_kana' => 'シコクチホウ']);
        PrefectureRegion::create(['id' => 8, 'name' => '九州地方', 'name_kana' => 'キュウシュウチホウ']);
    }
}
