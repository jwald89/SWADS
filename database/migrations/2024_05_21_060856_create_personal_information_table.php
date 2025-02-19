<?php

use App\Enums\CivilStatus;
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
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->string('classification');
            $table->string('ips')->nullable();
            $table->string('category');
            $table->string('sector_type');
            $table->date('date_intake');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('extn_name')->nullable();
            $table->string('nick_name');
            $table->integer('age');
            $table->date('birthdate');
            $table->enum('sex', GenderTypes::values())->default(GenderTypes::Male->value);
            $table->string('purok')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay');
            $table->string('municipality');
            $table->enum('civil_stats', CivilStatus::values())->default(CivilStatus::Single->value);
            $table->string('job')->nullable();
            $table->string('educ_attainment')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('income')->nullable();
            $table->string('ofis_charge');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->foreign('modified_by')->references('id')->on('users');
            $table->timestamp('modified_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_information');
    }
};
