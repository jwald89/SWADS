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
        Schema::create('child_developments', function (Blueprint $table) {
            $table->id();
            $table->string('cdc_name');
            $table->date('date_encoded')->nullable();
            $table->string('municipality');
            $table->string('barangay');
            $table->string('purok')->nullable();
            $table->string('sitio')->nullable();
            $table->string('cdw_name');
            $table->string('status')->nullable();
            $table->string('lvl_recognition');
            $table->date('validity_of_cor');
            $table->string('no_entered_children');
            $table->string('no_feed_recepients');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->foreign('modified_by')->references('id')->on('users');
            $table->timestamp('modified_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_developments');
    }
};
