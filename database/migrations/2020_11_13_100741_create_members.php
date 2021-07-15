<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('profile_photo');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('member_code', 80);
            $table->string('dob');
            $table->string('blood_id');
            $table->string('gender');
            $table->string('email')->index('email');
            $table->string('religion');
            $table->string('mother_tongue_id');
            $table->string('marital_status_id')->nullable();
            $table->string('phone_no');
            $table->boolean('email_verified_at')->nullable();
            $table->boolean('profile_verified')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['username', 'member_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
