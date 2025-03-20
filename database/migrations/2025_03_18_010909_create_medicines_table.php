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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('brgy');
            $table->string('municipality');
            $table->string('province')->nullable();
            $table->date('date_started');
            $table->date('date_ended');
            $table->string('pharmacy')->nullable();
            $table->decimal('amount', 10, 3);
            $table->string('type_assistance')->nullable();
            $table->string('beneficiary')->nullable();
            $table->string('relationship')->nullable();
            $table->string('kinds_of_med');
            $table->longText('problem_present');
            $table->longText('assistance_need');
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
        Schema::dropIfExists('medicines');
    }
};
