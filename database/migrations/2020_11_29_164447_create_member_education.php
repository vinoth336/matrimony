<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberEducation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_education', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('member_id');
            $table->string('degree');
            $table->string('course');
            $table->string('institute');
            $table->integer('passed_out');
            $table->string('remarks');
            $table->timestamps();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_education');
    }
}
