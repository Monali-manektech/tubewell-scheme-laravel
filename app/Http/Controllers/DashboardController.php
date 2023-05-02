<?php

namespace App\Http\Controllers;

use App\Models\Grampanchayat;
use App\Models\Item;
use App\Models\MasterPhase;
use App\Models\WorkOrder;
use App\Traits\Helper;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use Helper;

    public function index()
    {
		$master_phases = MasterPhase::all();
		$master_phase_wise_states = [];

		foreach ($master_phases as $master_phase) {
			$state = [
				"work_order" => WorkOrder::where('master_phase_slug', $master_phase->slug)->count(),
				'paid_amount' => 0,
				'total_amount' => 0,
				'remaining_amount' => 0,
				'remaining_amount_percent' => 0,
				'master_phase_slug' => $master_phase->slug,
				'name' => $master_phase->name
			];

			$workOrders = WorkOrder::select('id')->with('RAs', 'WorkOrderItems')
				->where('master_phase_slug', $master_phase->slug)->get();

			foreach ($workOrders as $workOrder) {
				$state['total_amount'] = $state['total_amount'] +  $this->calculateTotalAmount($workOrder);
				$state['paid_amount'] = $state['paid_amount'] +  $this->calculatePaidAmount($workOrder);
				$state['remaining_amount'] = $state['remaining_amount'] +  $this->calculateRemainingAmount($workOrder);
			}

			if ($state['total_amount'] > 0) {
				$state['remaining_amount_percent'] = ($state['remaining_amount'] * 100) / $state['total_amount'];
			}

			$state['paid_amount']       = $this->formatAmount($state['paid_amount']);
			$state['remaining_amount']  = $this->formatAmount($state['remaining_amount']);
			$state['remaining_amount_percent'] = $this->formatAmount($state['remaining_amount_percent']);

			$master_phase_wise_states[] = $state;
		}
        $title = "Dashboard";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ]
        ];

        return view('layouts.admin.dashboard', compact('title', 'breadcrumb', 'master_phase_wise_states'));
    }

    public function profile()
    {
        $title = "Profile";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ], [
                'title' => "Profile",
            ]
        ];

        return view('layouts.admin.profile', compact('title', 'breadcrumb'));
    }
}
