<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/07/25
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prefecture_regions', function (Blueprint $table) {
            $table->id()->comment('地方ID');

            $table->string('name', 255)->comment('地方名');
            $table->string('name_kana', 255)->comment('地方名カナ');

            $table->softDeletes()->comment('削除日');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->comment('作成者');
            $table->unsignedInteger('updated_by')->nullable()->comment('変更者');
            $table->unsignedInteger('deleted_by')->nullable()->comment('削除者');
            $table->unsignedInteger('restored_by')->nullable()->comment('復元者');

            $table->comment('地方マスタ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefecture_regions');
    }
};
