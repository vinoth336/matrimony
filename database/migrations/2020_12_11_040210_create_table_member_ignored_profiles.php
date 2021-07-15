<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMemberIgnoredProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_ignored_profiles', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('member_id');
            $table->uuid('ignored_member_id');
            $table->timestamps();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('ignored_member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_ignored_profiles');
    }
}
