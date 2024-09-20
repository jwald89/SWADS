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
            $table->unsignedBigInteger('mun_id')->nullable();
            $table->foreign('mun_id')->references('id')->on('municipalities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(Blueprint $table): void
    {
        $table->dropColun('mun_id');
    }
};
