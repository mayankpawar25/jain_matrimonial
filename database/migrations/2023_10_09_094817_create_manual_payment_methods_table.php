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
        // Existing installs already got this table from sqlupdates/v47.sql.
        if (Schema::hasTable('manual_payment_methods')) {
            return;
        }

        Schema::create('manual_payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('heading')->nullable();
            $table->text('description')->nullable();
            $table->text('bank_info')->nullable();
            $table->string('photo')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manual_payment_methods');
    }
};
