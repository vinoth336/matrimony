<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRenameParentsToFatherName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_families', function (Blueprint $table) {
            $table->renameColumn('parents', 'father_name');
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
            $table->renameColumn('father_name', 'parents');
        });
    }
}
