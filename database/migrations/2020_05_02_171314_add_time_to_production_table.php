<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeToProductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production', function (Blueprint $table) {
            $table->string('time');
            $table->dropColumn(['machine']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production', function (Blueprint $table) {
            $table->dropColumn(['time']);
            $table->string('machine');
        });
    }
}
