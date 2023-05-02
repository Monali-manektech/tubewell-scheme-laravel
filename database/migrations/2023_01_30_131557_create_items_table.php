<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_no');
            $table->bigInteger('parent_id')->nullable();
            $table->string('link')->nullable();
            $table->string('discipline')->nullable();
            $table->string('legend')->nullable();
            $table->text('description')->nullable();
            $table->integer('units')->nullable();
            $table->double('quantity',8,2)->nullable();
            $table->double('rate',16,2)->nullable();
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
        Schema::dropIfExists('items');
    }
};
