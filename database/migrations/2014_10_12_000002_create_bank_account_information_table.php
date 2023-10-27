<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/09/27
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\BankAccountHolderTypeCode;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bank_account_information', function (Blueprint $table) {
            $table->id()->comment('銀行口座情報ID');

            $table->foreignId('user_id')->constrained()->comment('ユーザーID');

            // 紹介報酬受取口座情報
            $table->string('bank_name')->nullable()->comment('銀行名');
            $table->string('bank_branch_name')->nullable()->comment('銀行支店名');

            // 口座種別のコメント作成
            $typeValues = collect(BankAccountHolderTypeCode::cases())->map(fn ($item) => $item->value)->toArray();
            $typeComment = collect(BankAccountHolderTypeCode::cases())
                // ->map(fn ($item) => "{$item}=" . BankAccountHolderTypeCode::from($item)->label())
                ->map(fn ($item) => $item->value . "=" . $item->label())
                ->join('、');
            $table->enum('bank_account_holder_type_code', $typeValues)->nullable()->comment('口座種別: ' . $typeComment);
            // $table->string('bank_account_holder_type_code')->nullable()->comment('口座種類');

            $table->string('bank_account_number')->nullable()->comment('口座番号');
            $table->string('bank_account_holder_name')->nullable()->comment('口座名義');

            $table->unsignedTinyInteger('is_active')->default(0)->comment('有効フラグ: 0=無効、1=有効');

            $table->softDeletes()->comment('削除日');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->comment('作成者');
            $table->unsignedInteger('updated_by')->nullable()->comment('変更者');
            $table->unsignedInteger('deleted_by')->nullable()->comment('削除者');
            $table->unsignedInteger('restored_by')->nullable()->comment('復元者');

            $table->comment('銀行口座情報');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_account_information');
    }
};
