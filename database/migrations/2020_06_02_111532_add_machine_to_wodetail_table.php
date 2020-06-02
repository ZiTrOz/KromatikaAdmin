<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMachineToWodetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wodetail', function (Blueprint $table) {
            $table->string('machine')->nullable();            
        });
        Schema::table('wo', function (Blueprint $table) {
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
        Schema::table('wodetail', function (Blueprint $table) {
            $table->dropColumn(['machine']);
        });
        Schema::table('wo', function (Blueprint $table) {
            $table->string('machine')->nullable();            
        });
    }
}
