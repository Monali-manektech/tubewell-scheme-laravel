@php
	$globalTotalWorkDoneAmount = 0;
	$globalTotalBalanceWorkAmount = 0;
	$globalTotalWorkDoneQTY = 0;
	$globalTotalBalanceWorkQTY = 0;
@endphp
<table>
	<thead>
		<tr>
			<td></td>
		</tr>
		<tr>
			<th>
				Scheme:
			</th>
			<th colspan="5">
				{{ $workOrder->name }}
			</th>
			<th></th>
			<th>
				Block:
			</th>
			<th colspan="3">
				{{ $workOrder->GramPanchayat ? $workOrder->GramPanchayat->blocks : '' }}
			</th>
			<th></th>
			<th>
				GramPanchayat:
			</th>
			<th colspan="3">
				{{ $workOrder->GramPanchayat ? $workOrder->GramPanchayat->name : '' }}
			</th>
		</tr>
	</thead>
</table>
<table class="table table-bordered" style="width:max-content">
    <thead>
        <tr>
            <th rowspan="2">SR.NO</th>
            <th rowspan="2">Item Number</th>
            <th rowspan="2">Link</th>
            <th rowspan="2">Discipline</th>
            <th rowspan="2">Legend</th>
            <th rowspan="2">Item Description</th>
            <th rowspan="2">Units</th>
            <th rowspan="2">Subitem Counts</th>
            <th rowspan="2">Qty</th>
            <th rowspan="2">Rate Per Unit</th>
            <th rowspan="2">Total Rate</th>
            <th rowspan="2">% of Payment allowed as per RFP</th>
            <th rowspan="2">Proposed billing Breakup
            <th rowspan="2">% of Payment Proposed</th>
            @forelse ($workOrderRas as $workOrderRa)
                <th colspan="2">{{ $workOrderRa->name }}</th>
            @empty
            @endforelse

            <th colspan="2">Work Done</th>
            <th colspan="2">Balance Work</th>
        </tr>
        <tr>
            @forelse ($workOrderRas as $workOrderRa)
                <th>QTY</th>
                <th>Amount</th>
            @empty
            @endforelse

            <th>QTY</th>
            <th>Amount</th>
            <th>QTY</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $itemKey => $item)
            @php
                $currentParentChildCount = 0;
                $itemDetailsParentChildCount = 0;
                $itemDetailsParentCount = count($item->ItemDetailsParent);
                
                foreach ($item->ItemDetailsParent as $itemDetailsParent) {
                    $itemDetailsParentChildCount = $itemDetailsParentChildCount + $itemDetailsParent->item_detail_childs_count;
                }
                
                if ($itemDetailsParentChildCount === 0) {
                    $itemDetailsParentChildCount = $itemDetailsParentCount;
                }
                $itemDetailsParentFirst = $item->ItemDetailsParent->first();
                
                if (!$itemDetailsParentFirst) {
                    $itemDetailsParentFirst = get_empty_workorder_item();
                }

                $itemDetailsChildFirst = $itemDetailsParentFirst->ItemDetailChilds->first();
                
                $itemDetailsParentRemaining = $item->ItemDetailsParent->filter(function ($itemDetailsParent, $key) {
                    if ($key > 0) {
                        return $itemDetailsParent;
                    }
                });

                if ($itemDetailsParentChildCount === 0) {
                    $itemDetailsParentChildCount = 1;
                }
            @endphp
            <tr>
                <td rowspan="{{ $itemDetailsParentChildCount }}">{{ $itemKey + 1 }}
                </td>
                <td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->item_no }} </td>
                <td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->link }} </td>
                <td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->discipline }} </td>
                @php $legend = App\Models\Legend::where('id', $item->legend)->whereNull('deleted_at')->first(); @endphp
                <td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $legend->name }} </td>
                <td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->description }} </td>
                <td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->units }} </td>
                <td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->child_items_count }} </td>
                <td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->quantity }} </td>
                <td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->formated_rate }} </td>
                <td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->total_rate }} </td>
                <td
                    rowspan="{{ $itemDetailsParentFirst->item_detail_childs_count > 0 ? $itemDetailsParentFirst->item_detail_childs_count : 1 }}">
                    {{ $itemDetailsParentFirst->item_praposed }}</td>
                <td>{{ $itemDetailsChildFirst->name ?? '-' }}</td>
                <td>
                    {{ $itemDetailsChildFirst && $itemDetailsChildFirst->percentage ? $itemDetailsChildFirst->percentage . '%' : '-' }}
                </td>

                @php
                    $workDoneRAQuantity = 0;
                    $workDoneRAAmount = 0;
                    $balanceWorkDoneQTY = 0;
                    $balanceWorkDoneAmount = 0;
                    
                    if($itemDetailsChildFirst) {
                        $workDoneRAQuantity = $workDoneRA[$itemDetailsChildFirst->id]['quantity'] ?? 0;
                        $workDoneRAAmount = $workDoneRA[$itemDetailsChildFirst->id]['amount'] ?? 0;
                        $balanceWorkDoneQTY = $workBalanceRA[$itemDetailsChildFirst->id]['quantity'] ?? 0;
                        $balanceWorkDoneAmount = $workBalanceRA[$itemDetailsChildFirst->id]['amount'] ?? 0;
                        
                        $globalTotalWorkDoneQTY = $globalTotalWorkDoneQTY + $workDoneRAQuantity;
                        $globalTotalWorkDoneAmount = $globalTotalWorkDoneAmount + $workDoneRAAmount;
                        $globalTotalBalanceWorkQTY = $globalTotalBalanceWorkQTY + $balanceWorkDoneQTY;
                        $globalTotalBalanceWorkAmount = $globalTotalBalanceWorkAmount + $balanceWorkDoneAmount;
                    }
                @endphp
                @forelse ($workOrderRas as $workOrderRa)
                    @if (isset($itemDetailsChildFirst->id))
                        @php
                            $ra_quantity = $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['quantity'] ?? 0;
                            $ra_amount = $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount'] ?? 0;
                        @endphp
                        <td> {{ $ra_quantity }} </td>
                        <td> {{ format_amount($ra_amount) }} </td>
                    @else
                        <td>0</td>
                        <td>0</td>
                    @endif

                @empty
                @endforelse

                <td>{{ $workDoneRAQuantity }}</td>
                <td>{{ format_amount($workDoneRAAmount) }}</td>
                <td>{{ $balanceWorkDoneQTY }}</td>
                <td>{{ format_amount($balanceWorkDoneAmount) }}</td>
            </tr>
            @php
                $itemDetailsParentFirstChildsRemaining = $itemDetailsParentFirst->ItemDetailChilds->filter(function ($itemDetailsChild, $key) {
                    if ($key > 0) {
                        return $itemDetailsChild;
                    }
                });
            @endphp

            @forelse ($itemDetailsParentFirstChildsRemaining as $child)
                @php
                    $childWorkDoneRAQuantity = $workDoneRA[$child->id]['quantity'] ?? 0;
                    $childWorkDoneRAAmount = $workDoneRA[$child->id]['amount'] ?? 0;
                    
                    $balanceWorkDoneQTY = $workBalanceRA[$child->id]['quantity'] ?? 0;
                    $balanceWorkDoneAmount = $workBalanceRA[$child->id]['amount'] ?? 0;
                    
                    $globalTotalWorkDoneQTY = $globalTotalWorkDoneQTY + $childWorkDoneRAQuantity;
                    $globalTotalWorkDoneAmount = $globalTotalWorkDoneAmount + $childWorkDoneRAAmount;
                    $globalTotalBalanceWorkQTY = $globalTotalBalanceWorkQTY + $balanceWorkDoneQTY;
                    $globalTotalBalanceWorkAmount = $globalTotalBalanceWorkAmount + $balanceWorkDoneAmount;
                @endphp
                <tr>
                    <td>{{ $child->name }}</td>
                    <td>{{ $child->percentage ? $child->percentage . ' %' : '-' }}</td>
                    @forelse ($workOrderRas as $workOrderRa)
                        @if (isset($child->id))
                            <td> {{ $workOrderRasLink[$workOrderRa->id][$child->id]['quantity'] ?? 0 }} </td>
                            <td>
                                {{ isset($workOrderRasLink[$workOrderRa->id][$child->id]['amount']) ? format_amount($workOrderRasLink[$workOrderRa->id][$child->id]['amount']) : 0 }}
                            </td>
                        @else
                            <td>0</td>
                            <td>0</td>
                        @endif
                    @empty
                    @endforelse

                    <td>{{ $childWorkDoneRAQuantity }}</td>
                    <td>{{ format_amount($childWorkDoneRAAmount) }}</td>
                    <td>{{ $balanceWorkDoneQTY }}</td>
                    <td>{{ format_amount($balanceWorkDoneAmount) }}</td>
                </tr>
            @empty
            @endforelse
            {{-- @include('reports.item-child-render', ['itemDetailChild' => $itemDetailsParentFirstChildsRemaining]) --}}

            @forelse ($itemDetailsParentRemaining as $itemDetailsParent)
                @php
                    $itemDetailsChildCount = $itemDetailsParent->item_detail_childs_count;
                    $itemDetailsChildFirst = $itemDetailsParent->ItemDetailChilds->first();
                    
                    $itemDetailsChildRemaining = $itemDetailsParent->ItemDetailChilds->filter(function ($itemDetailsChild, $key) {
                        if ($key > 0) {
                            return $itemDetailsChild;
                        }
                    });
                    
                    $itemDetailsParentworkDoneRAQuantity = $workDoneRA[$itemDetailsChildFirst->id]['quantity'] ?? 0;
                    $itemDetailsParentworkDoneRAAmount = $workDoneRA[$itemDetailsChildFirst->id]['amount'] ?? 0;
                    $itemDetailsParentBalanceWorkDoneRAQuantity = $workBalanceRA[$itemDetailsChildFirst->id]['quantity'] ?? 0;
                    $itemDetailsParentBalanceWorkDoneRAAmount = $workBalanceRA[$itemDetailsChildFirst->id]['amount'] ?? 0;
                    
                    $globalTotalWorkDoneQTY = $globalTotalWorkDoneQTY + $itemDetailsParentworkDoneRAQuantity;
                    $globalTotalWorkDoneAmount = $globalTotalWorkDoneAmount + $itemDetailsParentworkDoneRAAmount;
                    $globalTotalBalanceWorkQTY = $globalTotalBalanceWorkQTY + $itemDetailsParentBalanceWorkDoneRAQuantity;
                    $globalTotalBalanceWorkAmount = $globalTotalBalanceWorkAmount + $itemDetailsParentBalanceWorkDoneRAAmount;
                    
                @endphp
                <tr>
                    <td rowspan={{ $itemDetailsChildCount > 0 ? $itemDetailsChildCount : 1 }}>
                        {{ $itemDetailsParent->item_praposed }}</td>
                    <td>{{ $itemDetailsChildFirst->name ?? '-' }}</td>
                    <td>{{ $itemDetailsChildFirst->percentage ? $itemDetailsChildFirst->percentage . "%" : '-' }}</td>
                    @forelse ($workOrderRas as $workOrderRa)
                        @if (isset($itemDetailsChildFirst->id))
                            <td> {{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['quantity'] ?? 0 }} </td>
                            <td>
                                {{ isset($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount']) ? format_amount($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount']) : 0 }}
                            </td>
                        @else
                            <td>0</td>
                            <td>0</td>
                        @endif
                    @empty
                    @endforelse
                    <td>{{ $workDoneRAQuantity }}</td>
                    <td>{{ format_amount($workDoneRAAmount) }}</td>
                    <td>{{ $itemDetailsParentBalanceWorkDoneRAQuantity }}</td>
                    <td>{{ format_amount($itemDetailsParentBalanceWorkDoneRAAmount) }}</td>
                </tr>

                @forelse ($itemDetailsChildRemaining as $child)
                    @php
                        $childWorkDoneRAQuantity = $workDoneRA[$child->id]['quantity'] ?? 0;
                        $childWorkDoneRAAmount = $workDoneRA[$child->id]['amount'] ?? 0;
                        
                        $balanceWorkDoneQTY = $workBalanceRA[$child->id]['quantity'] ?? 0;
                        $balanceWorkDoneAmount = $workBalanceRA[$child->id]['amount'] ?? 0;
                        
                        $globalTotalWorkDoneQTY = $globalTotalWorkDoneQTY + $childWorkDoneRAQuantity;
                        $globalTotalWorkDoneAmount = $globalTotalWorkDoneAmount + $childWorkDoneRAAmount;
                        $globalTotalBalanceWorkQTY = $globalTotalBalanceWorkQTY + $balanceWorkDoneQTY;
                        $globalTotalBalanceWorkAmount = $globalTotalBalanceWorkAmount + $balanceWorkDoneAmount;
                    @endphp
                    <tr>
                        <td>{{ $child->name }}</td>
                        <td>{{ $child->percentage }}%</td>
                        @forelse ($workOrderRas as $workOrderRa)
                            @if (isset($child->id))
                                <td> {{ $workOrderRasLink[$workOrderRa->id][$child->id]['quantity'] ?? 0 }} </td>
                                <td>
                                    {{ isset($workOrderRasLink[$workOrderRa->id][$child->id]['amount']) ? format_amount($workOrderRasLink[$workOrderRa->id][$child->id]['amount']) : 0 }}
                                </td>
                            @else
                                <td>0</td>
                                <td>0</td>
                            @endif
                        @empty
                        @endforelse
                        <td>{{ $childWorkDoneRAQuantity }}</td>
                        <td>{{ format_amount($childWorkDoneRAAmount) }}</td>
                        <td>{{ $balanceWorkDoneQTY }}</td>
                        <td>{{ format_amount($balanceWorkDoneAmount) }}</td>
                    </tr>
                @empty
                @endforelse
            @empty
            @endforelse
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th colspan="14">Total</th>
            @forelse ($workOrderRas as $workOrderRa)
                <th>{{ isset($totalByRA[$workOrderRa->id]['quantity']) ? $totalByRA[$workOrderRa->id]['quantity'] : 0 }}</th>
                <th>
                    {{ isset($totalByRA[$workOrderRa->id]['amount']) ? format_amount($totalByRA[$workOrderRa->id]['amount']) : 0 }}
                </th>
            @empty
            @endforelse

            <th>{{ $globalTotalWorkDoneQTY }}</th>
            <th>{{ format_amount($globalTotalWorkDoneAmount) }}</th>
            <th>{{ $globalTotalBalanceWorkQTY }}</th>
            <th>{{ format_amount($globalTotalBalanceWorkAmount) }}</th>
        </tr>
    </tfoot>
</table>