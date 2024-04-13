<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMembersModifyEmailColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('represent_by_id')->nullable()->change();
        });

        Schema::table('member_registration_requests', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('represent_by_id')->nullable()->change();
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
            $table->string('email')->nullable()->change();
            $table->string('represent_by_id')->nullable()->change();
        });

        Schema::table('member_registration_requests', function (Blueprint $table) {
            $table->string('email')->change();
            $table->string('represent_by_id')->change();
        });
    }
}
