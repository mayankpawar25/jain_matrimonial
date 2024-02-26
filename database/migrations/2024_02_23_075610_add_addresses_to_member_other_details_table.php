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
        Schema::table('member_other_details', function (Blueprint $table) {
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_other_details', function (Blueprint $table) {
            $table->dropColumn(['present_address', 'permanent_address']);
        });
    }
};
