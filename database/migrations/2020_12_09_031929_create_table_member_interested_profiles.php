<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMemberInterestedProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_interested_profiles', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('member_id');
            $table->uuid('profile_member_id');
            $table->integer('request_status');
            $table->timestamp('request_accept_on')->nullable();
            $table->timestamps();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('profile_member_id')->references('id')->on('members')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_interested_profiles');
    }
}
