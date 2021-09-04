<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMemberFamilyAddColumnsFamilyMembersOccupationDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_families', function (Blueprint $table) {
            $table->string("about_father", 500);
            $table->string("about_mother", 500);
            $table->string("about_brothers", 500);
            $table->string("about_sisters", 500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_families', function (Blueprint $table) {
            $table->dropColumn([
                'about_father',
                'about_mother',
                'about_brothers',
                'about_sisters'
            ]);
        });
    }
}
