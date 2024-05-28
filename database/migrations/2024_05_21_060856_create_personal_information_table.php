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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->nullable();
            $table->string('classification');
            $table->string('category');
            $table->date('date_intake');
            $table->string('lastname', 100);
            $table->string('firstname', 100);
            $table->string('middlename', 100);
            $table->string('nick_name', 100);
            $table->string('age');
            $table->date('birthdate');
            $table->enum('sex', GenderTypes::values())->default(GenderTypes::IS_MALE->value);
            $table->string('purok');
            $table->string('barangay');
            $table->string('municipality');
            $table->enum('civil_stats', CivilStatus::values())->default(CivilStatus::Single->value);
            $table->string('job')->nullable();
            $table->string('contact_no')->nullable();
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
