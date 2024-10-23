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
        Schema::create('sectorals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('age');
            $table->enum('sex', GenderTypes::values())->default(GenderTypes::Male->value);
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('purok')->nullable();
            $table->string('barangay');
            $table->string('municipality');
            $table->date('birthdate');
            $table->string('place_birth');
            $table->string('physical_disability')->nullable();
            $table->enum('civil_status', CivilStatus::values())->default(CivilStatus::Single->value);
            $table->string('contact_no')->nullable();
            $table->string('fb_accnt')->nullable();
            $table->date('school_last_attend')->nullable();
            $table->string('month_year')->nullable();
            $table->string('skills')->nullable();
            $table->string('interest_hobby')->nullable();
            $table->string('work_exp')->nullable();
            $table->string('org_membership')->nullable();
            $table->integer('fam_members')->nullable();
            $table->string('ISY_OSY')->nullable();
            $table->string('position')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectorals');
    }
};
