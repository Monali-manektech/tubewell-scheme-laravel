<?php

namespace App\Exports;

use App\Models\Item;
use App\Models\RaDetails;
use App\Models\WorkOrderItems;
use App\Traits\Helper;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\Session;

class WorkOrderReportExport implements FromView, ShouldAutoSize, WithStyles, WithProperties, WithTitle
{
    use Helper;
    protected $workOrder;
    protected $legend;

    /**
     * Summary of __construct
     * @param \App\Models\WorkOrder $workOrder
     */

    public function __construct($workOrder, $legend)
    {
        $this->workOrder = $workOrder;
        $this->legend = $legend;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $workOrder = $this->workOrder;
        $workOrderRas = $workOrder->RAs->sortBy('id');

        if(isset($this->legend) && !empty($this->legend)){
            $items = WorkOrderItems::withCount('ChildItems')
            ->where('work_order_id', $workOrder->id)
            ->where('legend', $this->legend)
            ->withCount('ItemDetailsParent')
            // ->whereHas('ItemDetailsParent')
            // ->whereHas('ItemDetailsParent.ItemDetailChilds')
            ->with([
                'ItemDetailsParent' => function ($query) {
                    $query->withCount('ItemDetailChilds');
                },
                'ItemDetailsParent.ItemDetailChilds',
                'Unit'
            ])
            ->get();

        }else{
            $items = WorkOrderItems::withCount('ChildItems')
            ->where('work_order_id', $workOrder->id)
            ->withCount('ItemDetailsParent')
            // ->whereHas('ItemDetailsParent')
            // ->whereHas('ItemDetailsParent.ItemDetailChilds')
            ->with([
                'ItemDetailsParent' => function ($query) {
                    $query->withCount('ItemDetailChilds');
                },
                'ItemDetailsParent.ItemDetailChilds',
                'Unit'
            ])
            ->get();
        }        

        $workOrderRasLink = [];
        $workDoneRA = [];
        $totalByRA = [];
        $workBalanceRA = [];

        $workOrderBalance = $this->calculateWorkBalance($items);
        $workBalanceRA = $workOrderBalance;
        $raDetail = RaDetails::where('work_order_id', $workOrder->id)->get();

        if (isset($raDetail) && !empty(collect($raDetail))) {
            foreach ($raDetail->groupBy('r_a_id') as $key => $ra) {
                $workOrderRasLink[$key] = $ra->keyBy('work_order_item_detail_id')->toArray();
                $totalByRA[$key]['quantity'] = $this->calculateQty($ra);
                ;
                $totalByRA[$key]['amount'] = $ra->sum('amount');
            }

            foreach ($raDetail->groupBy('work_order_item_detail_id') as $k => $value) {
                $quantity = $this->calculateQty($value);
                $amount = $value->sum('amount');

                $workDoneRA[$k]['quantity'] = $quantity;
                $workDoneRA[$k]['amount'] = $amount;

                $workBalanceRA[$k]['quantity'] = array_key_exists($k, $workOrderBalance) ? $workOrderBalance[$k]['quantity'] - $quantity : 0;
                $workBalanceRA[$k]['amount'] = array_key_exists($k, $workOrderBalance) ? $workOrderBalance[$k]['amount'] - $amount : 0;
            }
        }

        return view('reports.ra-report-export', compact('workOrder', 'workOrderRas', 'items', 'workOrderRasLink', 'workDoneRA', 'totalByRA', 'workBalanceRA'));
    }

    // Set properties for the Sheet
    public function properties(): array
    {
        return [
            'creator' => Auth::user()->name,
            'lastModifiedBy' => Auth::user()->name,
            'title' => 'Invoices Export',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            2 => ['font' => ['bold' => true, 'size' => 18]],
            4 => ['font' => ['bold' => true, 'size' => 12]],
            5 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function title(): string
    {
        return $this->workOrder->GramPanchayat->name ?? 'Sheet 1';
    }
}