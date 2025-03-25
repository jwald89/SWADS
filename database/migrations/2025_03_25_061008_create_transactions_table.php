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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tfund');
            $table->string('obr_no')->unique()->nullable();
            $table->string('obr_date')->nullable();
            $table->string('claimant');
            $table->text('remarks')->nullable();
            $table->string('status')->nullable();
            $table->string('liaison');
            $table->string('pr_no')->unique()->nullable();
            $table->decimal('pr_amt', 10, 2)->nullable();
            $table->string('po_date')->nullable();
            $table->string('po_no')->unique()->nullable();
            $table->text('po_description')->nullable();
            $table->decimal('po_amt', 10, 2)->nullable();
            $table->string('dv_date')->nullable();
            $table->string('dv_no')->unique()->nullable();
            $table->decimal('dv_amt', 10, 2)->nullable();
            $table->string('check_date')->nullable();
            $table->string('check_no')->unique()->nullable();
            $table->decimal('check_amt', 10, 2)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->foreign('modified_by')->references('id')->on('users');
            $table->timestamp('modified_date')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
