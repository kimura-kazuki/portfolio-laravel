<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserRole;
use App\Enums\Sex;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('ユーザーID');
            $table->unsignedInteger('membership_number')->nullable()->comment('会員番号');

            $table->foreignId('company_id')->nullable()->constrained()->comment('会社ID');

            $table->string('name')->comment('名前');
            $table->string('name_kana')->nullable()->comment('フリガナ');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('パスワード');

            $table->string('phone', 16)->nullable()->comment('電話番号');

            $sexValues = collect(Sex::cases())->map(fn ($item) => $item->value)->toArray();
            $table->enum('sex_code', $sexValues)->length(1)->default('0')
                ->comment('性別コード ISO 5218: 0=not known（不明）、1=male（男性）、2=female（女性）、9=not applicable（適用不能）');
            // $table->string('age')->nullable()->comment('年齢');
            $table->date('date_of_birth')->nullable()->comment('生年月日');

            // 権限のコメント作成
            $roleValues = collect(UserRole::cases())->map(fn ($item) => $item->value)->toArray();
            $roleComment = collect(UserRole::cases())
                // ->map(fn ($item) => "{$item}=" . UserRole::from($item)->label())
                ->map(fn ($item) => $item->value . "=" . $item->label())
                ->join('、');
            $table->enum('role', $roleValues)->default(UserRole::Staff->value)->comment('権限: ' . $roleComment);

            $table->string('introducer_code')->nullable()->comment('紹介者コード');

            $table->string('google_id')->nullable()->comment('Google Auth ID');

            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            $table->timestamp('last_login_at')->nullable()->comment('最終ログイン時間');

            $table->softDeletes()->comment('削除日');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->comment('作成者');
            $table->unsignedInteger('updated_by')->nullable()->comment('変更者');
            $table->unsignedInteger('deleted_by')->nullable()->comment('削除者');
            $table->unsignedInteger('restored_by')->nullable()->comment('復元者');

            // 論理削除とユニーク制約を両立させる設定
            $table->boolean('exist')->nullable()->storedAs('case when deleted_at is null then 1 else null end')
                ->comment('存在フラグ: 論理削除とユニーク制約を両立させるためのフラグ');
            $table->unique(['email', 'role', 'exist']);

            $table->comment('ユーザーマスタ');
        });

        // ngramでFullTextSearchを実行するための設定
        \DB::statement("ALTER TABLE users ADD FULLTEXT index ftx_users_name (name) with parser ngram");
        \DB::statement("ALTER TABLE users ADD FULLTEXT index ftx_users_name_kana (name_kana) with parser ngram");
        \DB::statement("ALTER TABLE users ADD FULLTEXT index ftx_users_email (email) with parser ngram");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
