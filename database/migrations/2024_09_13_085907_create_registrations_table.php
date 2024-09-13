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
        $table->string('ampm');
        $table->string('place_of_birth');
        $table->string('state');
        $table->string('gotra_self');
        $table->string('gotra_mama');
        $table->string('caste');
        $table->string('subCaste');
        $table->string('weight');
        $table->string('height');
        $table->string('complexion');
        $table->integer('category');
        $table->string('residence');
        $table->string('education')->nullable();
        $table->string('occupation')->nullable();
        $table->string('maritalStatus')->nullable();
        $table->string('fatherName')->nullable();
        $table->string('mob')->nullable();
        $table->string('work')->nullable();
        $table->string('mothername')->nullable();
        $table->string('mob2')->nullable();
        $table->string('work2')->nullable();
        $table->string('income2')->nullable();
        $table->string('addres')->nullable();
        $table->string('sibling')->nullable();
        $table->string('married_brother')->nullable();
        $table->string('unmarried_brother')->nullable();
        $table->string('married_sister')->nullable();
        $table->string('unmarried_sister')->nullable();
        $table->string('contact');
        $table->string('social_group')->nullable();
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
