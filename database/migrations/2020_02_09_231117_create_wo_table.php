<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wonumber');
            $table->string('folio');
            $table->string('date');
            $table->string('customer');
            $table->string('phone');
            $table->string('delivery');
            $table->float('advance');
            $table->float('toPay');
            $table->float('subtotal');
            $table->float('iva');
            $table->float('total');
            $table->string('status');
            $table->date('delivery_date');
            $table->string('machine');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wo');
    }
}
