<?php

use App\Models\ItemDetail;
use App\Models\WorkOrderItems;
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
        Schema::create('work_order_item_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WorkOrderItems::class);
            $table->foreignIdFor(ItemDetail::class)->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('name')->nullable();
            $table->double('percentage',8,2)->nullable();
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
        Schema::dropIfExists('work_order_item_details');
    }
};
