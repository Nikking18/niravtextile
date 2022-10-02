<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inword_id')->unsigned()->index()->nullable();
            $table->unsignedBigInteger('item_id')->unsigned()->index()->nullable();
            $table->string('item_name')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->bigInteger('rate')->nullable();
            $table->double('amount')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('inword_id')->references('id')->on('inwords')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
