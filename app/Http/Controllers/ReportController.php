<?php

namespace App\Http\Controllers;

use App\Exports\WorkOrderReportExport;
use App\Models\RaDetails;
use App\Models\WorkOrder;
use App\Models\WorkOrderItems;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Legend;

class ReportController extends Controller
{
    use Helper;

    public function index() {
        $workOrders = WorkOrder::select('id', 'name')->get();
        $title = "Export WorkOrders";

        return view('reports.index', compact('workOrders', 'title'));
    }

    public function export(Request $request,$workOrder = null) {
        if(strtolower($request->method()) === "post") {
            $legend = '';
            $workOrder = WorkOrder::with('RAs')->where('id', $workOrder)->firstOrFail();
            if(!$workOrder) {
                Session::flash('error', 'No workorder found.');

                return redirect()->route('work-orders.index');
            }

            return Excel::download(new WorkOrderReportExport($workOrder,$legend), 'workOrders.xlsx');
        } else {
            if(!$workOrder) {
                Session::flash('info', 'No workorder found.');
                return redirect()->route('report.index');
            }
            $workOrder = WorkOrder::with('RAs')->where('id', $workOrder)->firstOrFail();
            $workOrders = WorkOrder::select('id', 'name')->get();
            $workOrderRas = $workOrder->RAs->sortBy('id');
            $items = WorkOrderItems::
                        withCount('ChildItems')
                        ->where('work_order_id', $workOrder->id)
                        ->withCount('ItemDetailsParent')
                        // ->whereHas('ItemDetailsParent')
                        // ->whereHas('ItemDetailsParent.ItemDetailChilds')
                        ->with(['ItemDetailsParent' => function ($query) {
                            $query->withCount('ItemDetailChilds');
                        }, 'ItemDetailsParent.ItemDetailChilds', 'Unit'])
                        ->get();
			$items = $items->sortBy('item_order', true);
			$totalRate = 0;
			foreach ($items as $item) {
				$totalRate = $totalRate + (float)($item->quantity * $item->rate);
			}

            $workOrderRasLink = [];
            $workDoneRA = [];
            $workBalanceRA = [];
            $totalByRA = [];
            $totalByRA = [];

            $workOrderBalance = $this->calculateWorkBalance($items);
            $workBalanceRA = $workOrderBalance;
            $raDetail = RaDetails::where('work_order_id', $workOrder->id)->orderBy('id')->get();
            if(isset($raDetail) && !empty(collect($raDetail))){

                // For RA value display
                foreach($raDetail->groupBy('r_a_id') as $key => $ra){
                    $workOrderRasLink[$key] = $ra->keyBy('work_order_item_detail_id')->toArray();

                    $totalByRA[$key]['quantity'] = $this->calculateQty($ra);
                    $totalByRA[$key]['amount'] = $ra->sum('amount');
                }
                // dd($raDetail->groupBy('work_order_item_detail_id'), $workOrderBalance);
                // For work done calculation
                foreach($raDetail->groupBy('work_order_item_detail_id') as $k => $value){
                    $quantity = $this->calculateQty($value);
                    $amount = $value->sum('amount');

                    $workDoneRA[$k]['quantity'] = $quantity;
                    $workDoneRA[$k]['amount'] = $amount;

                    $workBalanceRA[$k]['quantity'] = array_key_exists($k, $workOrderBalance) ? $workOrderBalance[$k]['quantity'] - $quantity : 0;
                    $workBalanceRA[$k]['amount'] = array_key_exists($k, $workOrderBalance) ? round($workOrderBalance[$k]['amount'], 2) - $amount : 0;
                }
            }
            $legends = Legend::whereNull('deleted_at')->where('master_phase_slug', $workOrder->master_phase_slug)->get();
            $workOrder_id = $workOrder->id;
            $requested_legend = '';
            return view('reports.ra-report', compact('totalRate','workOrder', 'workOrderRasLink', 'items', 'workOrderRas','workOrders', 'workDoneRA', 'raDetail', 'totalByRA' , 'workBalanceRA', 'workOrderBalance','legends','workOrder_id','requested_legend'));
        }
    }

    public function filterReportThroughLegend()
    {
        $workOrder_id = request()->workOrder_id;
		$legend = request()->legend;
        if(request()->isMethod('post')){
            $workOrder = WorkOrder::with('RAs')->where('id', $workOrder_id)->firstOrFail();
            if(empty($workOrder)) {
                Session::flash('error', 'No workorder found.');

                return redirect()->route('work-orders.index');
            }
            if(isset(request()->legend) && !empty(request()->legend)){
                return Excel::download(new WorkOrderReportExport($workOrder,$legend), 'workOrders.xlsx');
            }else{
                $legend = '';
                return Excel::download(new WorkOrderReportExport($workOrder,$legend), 'workOrders.xlsx');
            }
        }
        $workOrder = WorkOrder::with('RAs')->where('id', $workOrder_id)->firstOrFail();
        $workOrders = WorkOrder::select('id', 'name')->get();
        // $workOrderRas = $workOrder->RAs->sortBy('id');
        $workOrderRas_arr = WorkOrder::where('id', $workOrder_id)->with('RAs')->orderBy('id','asc')->first();
		$workOrderRas_json = json_decode($workOrderRas_arr);
		$workOrderRas = $workOrderRas_json->r_as;
        if(isset(request()->legend) && !empty(request()->legend)){
            $items = WorkOrderItems::
                withCount('ChildItems')
                ->where('work_order_id', $workOrder->id)
                ->where('legend', $legend)
                ->withCount('ItemDetailsParent')
                // ->whereHas('ItemDetailsParent')
                // ->whereHas('ItemDetailsParent.ItemDetailChilds')
                ->with(['ItemDetailsParent' => function ($query) {
                    $query->withCount('ItemDetailChilds');
                }, 'ItemDetailsParent.ItemDetailChilds', 'Unit'])
                ->get();
        }else{
            $items = WorkOrderItems::
                withCount('ChildItems')
                ->where('work_order_id', $workOrder->id)
                ->withCount('ItemDetailsParent')
                // ->whereHas('ItemDetailsParent')
                // ->whereHas('ItemDetailsParent.ItemDetailChilds')
                ->with(['ItemDetailsParent' => function ($query) {
                    $query->withCount('ItemDetailChilds');
                }, 'ItemDetailsParent.ItemDetailChilds', 'Unit'])
                ->get();
        }


        $workOrderRasLink = [];
        $workDoneRA = [];
        $workBalanceRA = [];
        $totalByRA = [];
        $totalByRA = [];

        $workOrderBalance = $this->calculateWorkBalance($items);
        $workBalanceRA = $workOrderBalance;
        $raDetail = RaDetails::where('work_order_id', $workOrder->id)->orderBy('id')->get();
        if(isset($raDetail) && !empty(collect($raDetail))){

            // For RA value display
            foreach($raDetail->groupBy('r_a_id') as $key => $ra){
                $workOrderRasLink[$key] = $ra->keyBy('work_order_item_detail_id')->toArray();

                $totalByRA[$key]['quantity'] = $this->calculateQty($ra);
                $totalByRA[$key]['amount'] = $ra->sum('amount');
            }
            // dd($raDetail->groupBy('work_order_item_detail_id'), $workOrderBalance);
            // For work done calculation
            foreach($raDetail->groupBy('work_order_item_detail_id') as $k => $value){
                $quantity = $this->calculateQty($value);
                $amount = $value->sum('amount');

                $workDoneRA[$k]['quantity'] = $quantity;
                $workDoneRA[$k]['amount'] = $amount;

                $workBalanceRA[$k]['quantity'] = array_key_exists($k, $workOrderBalance) ? $workOrderBalance[$k]['quantity'] - $quantity : 0;
                $workBalanceRA[$k]['amount'] = array_key_exists($k, $workOrderBalance) ? round($workOrderBalance[$k]['amount'], 2) - $amount : 0;
            }
        }
        $legends = Legend::whereNull('deleted_at')->where('master_phase_slug', $workOrder->master_phase_slug)->get();
        $workOrder_id = $workOrder->id;
        $requested_legend = $legend;
        $filter_request_route = route('report.filter.legend',['legend' => $requested_legend, 'workOrder_id' => $workOrder_id]);
        return view('reports.ra-report', compact('workOrder', 'workOrderRasLink', 'items', 'workOrderRas','workOrders', 'workDoneRA', 'raDetail', 'totalByRA' , 'workBalanceRA', 'workOrderBalance','legends','workOrder_id','requested_legend','filter_request_route'));
    }
}
