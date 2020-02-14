<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ponumber');
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
        Schema::dropIfExists('po');
    }
}
