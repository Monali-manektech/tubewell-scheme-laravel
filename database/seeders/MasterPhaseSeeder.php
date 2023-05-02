<?php

namespace Database\Seeders;

use App\Models\MasterPhase;
use Illuminate\Database\Seeder;

class MasterPhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
			[
				'name' => 'Master Phase 1',
				'slug' => 'master-phase-1',
				'description' => 'Master Phase 1'
			],
			[
				'name' => 'Master Phase 2',
				'slug' => 'master-phase-2',
				'description' => 'Master Phase 2'
			],
			[
				'name' => 'Master Phase 3',
				'slug' => 'master-phase-3',
				'description' => 'Master Phase 3'
			]
		];

		MasterPhase::truncate();
		foreach ($data as $master_data) {
			MasterPhase::create($master_data);
		}
    }
}
