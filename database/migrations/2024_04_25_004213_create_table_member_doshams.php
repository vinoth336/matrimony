<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMemberDoshams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_dhosams', function (Blueprint $table) {
            $table->id();
            $table->uuid('member_id');
            $table->integer('dhosam_id');
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('member_id')->references('id')->on('members')->cascadeOnDelete();
            $table->foreign('dhosam_id')->references('id')->on('dhosams')->cascadeOnDelete();

            // Define a unique constraint to prevent duplicate entries
            $table->unique(['member_id', 'dhosam_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_dhosams');
    }
}
