<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableShareMyPhoneNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_share_my_phone_number_to_partner', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('from_member_id');
            $table->uuid('to_member_id');
            $table->enum('status', ['request', 'sent', 'discussed', 'not-interest', 'accepted'])->default('request');
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('member_share_my_phone_number_to_partner');
    }
}
