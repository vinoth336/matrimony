<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_locations', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('member_id');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->string('address');
            $table->integer('city_id');
            $table->foreign('city_id')->references('id')->on('city');
            $table->integer('state_id');
            $table->foreign('state_id')->references('id')->on('state');
            $table->integer('pincode');
            $table->string('landmark');
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
        Schema::dropIfExists('member_locations');
    }
}
