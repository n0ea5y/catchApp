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
        Schema::table('users', function ( Blueprint $table) {
            $table->integer('commission')->after('password')->comment('歩合％');
            $table->enum('tax',[1,0])->after('password')->comment('税込み、税別');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('commission');
            $table->dropColumn('tax');
        });
    }
};
