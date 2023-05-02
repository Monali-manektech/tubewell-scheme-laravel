<?php

namespace App\Http\Controllers;

use App\Models\MasterPhase;
use App\Models\RA;
use App\Models\RaDetails;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class RAController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, $workOrderID = null)
    {
        $title = "RA's";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "RA",
            ],
        ];


        if($request->ajax()) {
            $ras = RA::query()->with('WorkOrder', 'RADetails');
            if($workOrderID) {
                $ras = $ras->where('work_order_id', $workOrderID);
            }

			$master_phase_slug = !empty($request->master_phase) ? $request->master_phase : 'master-phase-1';
			$ras = $ras->where('master_phase_slug' , $master_phase_slug);
			Session::put('master_phase_slug', $master_phase_slug);

            return DataTables::of($ras)
            ->addIndexColumn()
            ->editColumn('work_order_id', function($data){
                return $data->WorkOrder ? $data->WorkOrder->name : null;
            })
            ->editColumn('amount', function($data){
                return $this->formatAmount($data->amount);
            })
            ->addColumn('item_amount', function($data){
                return $this->formatAmount($data->RADetails->sum('amount'));
            })
            ->addColumn('action', function($data){
                return view('ra._form_actions', compact('data'))->render();
            })
            ->make();
        }
		$master_phases = MasterPhase::all();
		$master_phase_slug = Session::get('master_phase_slug');
        return view('ra.index', compact('title', 'breadcrumb', 'workOrderID', 'master_phases', 'master_phase_slug'));
    }


    public function create()
    {
		$master_phase_slug = Session::get('master_phase_slug');
        $title = "RA's for " . $master_phase_slug;
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "RA's",
                'link' => route('ra.index')
            ],
            [
                'title' => "Add RA",
            ],
        ];
        return view('ra.create', compact('title', 'breadcrumb'));
    }

    public function edit(RA $ra)
    {
		$master_phase_slug = Session::get('master_phase_slug');
        $title = "Edit RA for " . $master_phase_slug;
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "RA",
                'link' => route('ra.index')
            ],
            [
                'title' => "Edit RA",
            ],
        ];
        return view('ra.edit', compact('title', 'breadcrumb', 'ra'));
    }

    public function destroy(RA $ra)
    {
		$ra_details = RaDetails::where('r_a_id', $ra->id)->get();
		foreach ($ra_details as $ra_detail) {
			$ra_detail->delete();
		}
        $ra->delete();
        Session::flash('success', 'RA deleted successfully.');

        return redirect()->route('ra.index');
    }
}
