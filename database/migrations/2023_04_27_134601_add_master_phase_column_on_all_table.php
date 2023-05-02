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
        Schema::table('items', function (Blueprint $table) {
            $table->string('master_phase_slug')->after('id')->nullable()->default('master-phase-1');
        });

		Schema::table('grampanchayats', function (Blueprint $table) {
			$table->string('master_phase_slug')->after('id')->nullable()->default('master-phase-1');
		});

		Schema::table('item_details', function (Blueprint $table) {
			$table->string('master_phase_slug')->after('id')->nullable()->default('master-phase-1');
		});

		Schema::table('legends', function (Blueprint $table) {
			$table->string('master_phase_slug')->after('id')->nullable()->default('master-phase-1');
		});

		Schema::table('ra_details', function (Blueprint $table) {
			$table->string('master_phase_slug')->after('id')->nullable()->default('master-phase-1');
		});

		Schema::table('r_a_s', function (Blueprint $table) {
			$table->string('master_phase_slug')->after('id')->nullable()->default('master-phase-1');
		});

		Schema::table('units', function (Blueprint $table) {
			$table->string('master_phase_slug')->after('id')->nullable()->default('master-phase-1');
		});

		Schema::table('work_orders', function (Blueprint $table) {
			$table->string('master_phase_slug')->after('id')->nullable()->default('master-phase-1');
		});

		Schema::table('work_order_items', function (Blueprint $table) {
			$table->string('master_phase_slug')->after('id')->nullable()->default('master-phase-1');
		});

		Schema::table('work_order_item_details', function (Blueprint $table) {
			$table->string('master_phase_slug')->after('id')->nullable()->default('master-phase-1');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('master_phase_slug');
        });

		Schema::table('grampanchayats', function (Blueprint $table) {
            $table->dropColumn('master_phase_slug');
        });

		Schema::table('item_details', function (Blueprint $table) {
            $table->dropColumn('master_phase_slug');
        });

		Schema::table('legends', function (Blueprint $table) {
            $table->dropColumn('master_phase_slug');
        });

		Schema::table('ra_details', function (Blueprint $table) {
            $table->dropColumn('master_phase_slug');
        });

		Schema::table('r_a_s', function (Blueprint $table) {
            $table->dropColumn('master_phase_slug');
        });

		Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('master_phase_slug');
        });

		Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('master_phase_slug');
        });

		Schema::table('work_order_items', function (Blueprint $table) {
            $table->dropColumn('master_phase_slug');
        });

		Schema::table('work_order_item_details', function (Blueprint $table) {
            $table->dropColumn('master_phase_slug');
        });
    }
};
