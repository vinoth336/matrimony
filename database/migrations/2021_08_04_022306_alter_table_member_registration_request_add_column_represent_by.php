<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMemberRegistrationRequestAddColumnRepresentBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_registration_requests', function (Blueprint $table) {
            $table->uuid('represent_by_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_registration_requests', function (Blueprint $table) {
            $table->dropColumn('represent_by_id');
        });
    }
}
