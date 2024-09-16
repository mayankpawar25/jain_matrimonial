<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('marriage');
            $table->date('doc_date');
            $table->time('time');
            $table->string('ampm')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('place_of_birth');
            $table->string('state');
            $table->string('gotra_self');
            $table->string('gotra_mama');
            $table->string('caste');
            $table->string('subCaste');
            $table->string('weight');
            $table->string('height');
            $table->string('complexion');
            $table->string('category');
            $table->string('residence');
            $table->string('dosh')->nullable(); // Added 'dosh' field
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->string('fatherName')->nullable();
            $table->string('father_mobile')->nullable(); // Updated field for father's mobile
            $table->string('father_occupation')->nullable(); // Updated field for father's occupation
            $table->string('father_income')->nullable(); // Updated field for father's income
            $table->string('mothername')->nullable();
            $table->string('mother_mobile')->nullable(); // Updated field for mother's mobile
            $table->string('mother_occupation')->nullable(); // Updated field for mother's occupation
            $table->string('mother_income')->nullable(); // Updated field for mother's income
            $table->string('permanent_address')->nullable(); // Updated field for permanent address
            $table->string('sibling')->nullable();
            $table->string('married_brother')->nullable();
            $table->string('unmarried_brother')->nullable();
            $table->string('married_sister')->nullable();
            $table->string('unmarried_sister')->nullable();
            $table->string('contact');
            $table->string('social_group')->nullable();
            $table->string('profile_picture')->nullable(); // Added field for profile picture
            $table->string('payment_picture')->nullable(); // Added field for payment picture
            $table->string('payment_type')->nullable(); // Added field for payment type
            $table->string('total_payment')->nullable(); // Added field for total payment
            $table->boolean('is_courier')->default(false); // Added field for courier option
            $table->string('payment_mode')->nullable(); // Added field for payment mode
            $table->integer('trem_condition')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};
