<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMembersAddColumnProfileAndHoroscopeLock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('profile_lock')->nullable();
            $table->boolean('profile_photo_lock')->nullable();
            $table->boolean('horoscope_lock')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'profile_lock',
                'profile_photo_lock',
                'horoscope_lock'
            ]);
        });
    }
}
