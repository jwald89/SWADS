<?php

use App\Enums\GenderTypes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('claimant');
            $table->date('date_encoded')->nullable();
            $table->string('beneficiary');
            $table->string('age');
            $table->enum('sex', GenderTypes::values())->default(GenderTypes::Male->value);
            $table->string('contact_no');
            $table->string('sector');
            $table->string('municipality');
            $table->string('barangay');
            $table->string('client_type');
            $table->string('assistance_type');
            $table->decimal('amount', 10, 3);
            $table->string('charges');
            $table->date('date_intake');
            $table->string('staff_admin');
            $table->string('liaison');
            $table->date('status_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('monitorings');
    }
};
