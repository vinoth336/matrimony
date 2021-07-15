<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberFamily extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_family', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('member_id');
            $table->string('family_type');
            $table->integer('parents');
            $table->integer('brothers');
            $table->integer('sisters');
            $table->integer('remarks');
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
        Schema::dropIfExists('member_family');
    }
}
