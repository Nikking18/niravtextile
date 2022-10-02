<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutwordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outwords', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id')->unsigned()->index()->nullable();
            $table->string('item_name')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->bigInteger('machine_number')->nullable();
            $table->string('person_name')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outwords');
    }
}
