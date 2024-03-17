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
        Schema::create('sales', function (Blueprint $table) {
            $table->id()->comment('Id');

            $table->bigInteger('users_id')->unsigned()->comment('ユーザーId');
            $table->foreign('users_id')->references('id')->on('users');

            $table->bigInteger('stores_id')->unsigned()->comment('ストアId');
            $table->foreign('stores_id')->references('id')->on('stores');

            $table->string('customer_payment')->comment('金額');
            $table->enum('deleted_at',[1,0])->comment('論理削除');
            $table->timestamp('created_at')->comment('作成日時');
            $table->timestamp('updated_at')->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
