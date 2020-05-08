<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('from')->nullable();
            $table->bigInteger('to');
            $table->string('movement');
            $table->string('code');
            $table->string('item');
            $table->string('quantity');
            $table->string('supplier')->nullable();
            // $table->bigInteger('wo_id')->nullable();
            // $table->bigInteger('wodetail_id')->nullable();
            $table->string('wonumber')->nullable();
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('transaction');
    }
}
