<?php

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
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('users');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('Id');

            $table->string('name', 15)->nullable(false)->comment('ユーザー名');
            $table->string('email', 255)->nullable()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable()->comment('メール確認可否');
            $table->string('password', 255)->comment('パスワード');
            $table->enum('role', [0, 1])->default(0)->nullable()->comment('権限');
            $table->enum('deleted_at', [0, 1])->default(0)->nullable()->comment('論理削除');
            $table->rememberToken()->comment('認証トークン');
	    $table->timestamp('created_at')->useCurrent()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
};
