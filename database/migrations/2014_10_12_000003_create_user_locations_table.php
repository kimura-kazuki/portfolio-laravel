<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/01/24
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
        Schema::create('user_locations', function (Blueprint $table) {
            $table->id()->comment('会員住所ID');

            $table->foreignId('user_id')->constrained()->comment('ユーザーID');

            $table->string('phone', 16)->nullable()->comment('電話番号');
            $table->string('postal_code', 7)->nullable()->comment('郵便番号');
            $table->foreignId('prefecture_id', 5)->nullable()->constrained()->comment('都道府県ID');
            $table->string('address1', 100)->nullable()->comment('市区町村');
            $table->string('address2', 100)->nullable()->comment('ビル・マンション名・号室');

            $table->string('comment', 1000)->nullable()->comment('コメント');

            $table->unsignedInteger('is_default')->default(0)->comment('既定値設定');

            $table->softDeletes()->comment('削除日');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->comment('作成者');
            $table->unsignedInteger('updated_by')->nullable()->comment('変更者');
            $table->unsignedInteger('deleted_by')->nullable()->comment('削除者');
            $table->unsignedInteger('restored_by')->nullable()->comment('復元者');

            $table->comment('会員住所テーブル');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_locations');
    }
};
