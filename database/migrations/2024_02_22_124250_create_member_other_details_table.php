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
        Schema::create('member_other_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');
            $table->integer('state_id')->nullable();

            $table->string('nationality')->nullable();
            $table->string('manglik')->nullable();
            $table->string('self_gotra')->nullable();
            $table->string('nanihals_gotra')->nullable();
            $table->string('house')->nullable();
            $table->string('qualification')->nullable();
            $table->string('occupation')->nullable();
            $table->string('job_description')->nullable();
            $table->string('position')->nullable();
            $table->string('organization_name')->nullable();
            $table->decimal('annual_income', 15, 2)->nullable();
            $table->string('father_mobile_no_1')->nullable();
            $table->string('father_mobile_no_2')->nullable();
            $table->string('father_occupation')->nullable();
            $table->decimal('father_annual_income', 15, 2)->nullable();
            $table->string('mother_mobile_no_1')->nullable();
            $table->string('mother_mobile_no_2')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->decimal('mother_annual_income', 15, 2)->nullable();
            $table->integer('unmarried_brother')->nullable();
            $table->integer('married_brother')->nullable();
            $table->integer('unmarried_sister')->nullable();
            $table->integer('married_sister')->nullable();
            
            $table->text('grandfather_uncle_info')->nullable();
            $table->string('known_person_1')->nullable();
            $table->string('known_person_2')->nullable();
            $table->string('known_member_digamber_jain_social_group')->nullable();
            $table->string('candidates_guardian_name')->nullable();
            $table->string('relation_with_candidate')->nullable();
            $table->string('transaction_id')->nullable();
            $table->decimal('transaction_amount', 15, 2)->nullable();
            $table->date('transaction_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_other_details');
    }
};
