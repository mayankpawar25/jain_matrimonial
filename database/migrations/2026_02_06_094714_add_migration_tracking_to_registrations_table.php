<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->boolean('is_migrated')->default(0)->after('payment_mode');
            $table->unsignedBigInteger('migrated_user_id')->nullable()->after('is_migrated');
            $table->timestamp('migrated_at')->nullable()->after('migrated_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['is_migrated', 'migrated_user_id', 'migrated_at']);
        });
    }
};
