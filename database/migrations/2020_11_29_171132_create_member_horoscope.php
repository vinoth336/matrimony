<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberHoroscope extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_horoscopes', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('member_id');
            $table->integer('star');
            $table->integer('rasi');
            $table->integer('lagnam');
            $table->string('dosham');
            $table->string('image', 300);
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
        Schema::dropIfExists('member_horoscopes');
    }
}
