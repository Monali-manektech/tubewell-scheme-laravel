<?php

use App\Models\RA;
use App\Models\WorkOrder;
use App\Models\WorkOrderItemDetail;
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
        Schema::create('ra_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RA::class);
            $table->foreignIdFor(WorkOrderItemDetail::class);
            $table->foreignIdFor(WorkOrder::class);
            $table->string('quantity')->nulable();
            $table->double('amount', 20,2)->nulable();
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
        Schema::dropIfExists('ra_details');
    }
};
