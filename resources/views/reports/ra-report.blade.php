@extends('layouts.admin.app')
@push('css')
	<style>
		/* table {
		position: absolute;
    	}
    	th {
    		position: sticky;
    		top: 0;
    		background: white;
    	} */
		.percentage_amount{
			color:red;
			font-weight: 400;
		}
	</style>
@endpush
@section('contents')
	@php
		$globalTotalWorkDoneAmount = 0;
		$globalTotalBalanceWorkAmount = 0;
		$globalTotalWorkDoneQTY = 0;
		$globalTotalBalanceWorkQTY = 0;
	@endphp
	<div class="row">
		<div class="col-6">
			<button class="btn btn-primary" onclick="javascript:history.back()">Go Back</button>
		</div>
		<div class="col-6">
			<div class="form-group row" style="float: right;">
				<label for="staticEmail" class="col-sm-4 col-form-label">Legend Filter :</label>
				<div class="col-sm-8 mr-n2">
				<form action="{{route('report.filter.legend')}}" method="GET">
					<select name="legend" class="form-control" onchange="this.form.submit()" style="width: 250px;float: right;" id="legend_filter">
						<option value="">Select Legend</option>
						@foreach($legends as $legend)
							<option value="{{$legend->id}}" {{$requested_legend == $legend->id ? 'selected' : ''}}>{{$legend->name}}</option>
						@endforeach
					</select>
					<input type="hidden" name="workOrder_id" value="{{$workOrder_id}}">
				</form>
				</div>
			</div>
		</div>
	</div>
	<div class="flash-message">
	@foreach (['danger', 'warning', 'success', 'info'] as $msg)
		@if(Session::has('alert-' . $msg))
		<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
		@endif
	@endforeach
	</div>
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-4">
					<h5>Scheme: {{ $workOrder->name }}</h5>
				</div>
				<div class="col-md-4">
					<h5>Block: {{ $workOrder->GramPanchayat ? $workOrder->GramPanchayat->blocks : null }}</h5>
				</div>
				<div class="col-md-4">
					<h5>Gram Panchayat: {{ $workOrder->GramPanchayat ? $workOrder->GramPanchayat->name : null }}</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					@isset($workOrders)
						<select class="form-control" onchange="goToWorkOrder(this.value)">
							@foreach ($workOrders as $value)
								<option value="{{ $value->id }}" @selected($value->id == $workOrder->id)>{{ $value->name }}</option>
							@endforeach
						</select>
					@endisset
				</div>
				<div class="col-md-3">
					<form action="{{ isset($filter_request_route) ? $filter_request_route : route('report.export', $workOrder->id) }}" method="post">
						@csrf
						<button class="btn btn-primary" type="submit">Export</button>
					</form>
				</div>
			</div>
		</div>
		<div class="card-body" style="overflow-x:scroll">
			<table class="table table-bordered" style="table-layout: fixed; width: max-content">
				<thead>
					<tr>
						<th rowspan="2">SR.NO</th>
						<th rowspan="2" width="150">Item Number</th>
						<th rowspan="2">Link</th>
						<th rowspan="2" width="100">Discipline</th>
						<th rowspan="2" width="100">Legend</th>
						<th rowspan="2" width="500">Item Description</th>
						<th rowspan="2">Units</th>
						<th rowspan="2">Subitem Counts</th>
						<th rowspan="2">Qty</th>
						<th rowspan="2">Rate Per Unit</th>
						<th rowspan="2">Total Rate</th>
						<th rowspan="2" width="250">% of Payment allowed as per RFP</th>
						<th rowspan="2" width="250">Proposed billing Breakup
						<th rowspan="2" width="150">% of Payment Proposed</th>
						@forelse ($workOrderRas as $workOrderRa)
							<th colspan="2">{{ $workOrderRa->name }}</th>
						@empty
						@endforelse

						<th colspan="2" class="bg-info">Work Done</th>
						<th colspan="2" class="bg-info">Balance Work</th>
					</tr>
					<tr>
						@forelse ($workOrderRas as $workOrderRa)
							<th>QTY</th>
							<th>Amount</th>
						@empty
						@endforelse

						<th class="bg-info">QTY</th>
						<th class="bg-info">Amount</th>
						<th class="bg-info">QTY</th>
						<th class="bg-info">Amount</th>
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
						<tr @class(['font-weight-bold' => empty($item->units) && ($item->rate == 0 || empty($item->rate))])>
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
								<div class="percentage_amount">{{ !empty($itemDetailsChildFirst->percentage) ? format_amount(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100) : '' }}</div>

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

							<td class="bg-info">{{ $workDoneRAQuantity }}</td>
							<td class="bg-info">{{ format_amount($workDoneRAAmount) }}</td>
							<td class="bg-info">{{ $balanceWorkDoneQTY }}</td>
							<td class="bg-info">{{ format_amount($balanceWorkDoneAmount) }}</td>
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
							<tr @class(['font-weight-bold' => empty($item->units) && ($item->rate == 0 || empty($item->rate))])>
								<td>{{ $child->name }}</td>
								<td>{{ $child->percentage ? $child->percentage . ' %' : '-' }}
									<div class="percentage_amount">{{ format_amount(($item->rate * $item->quantity * $child->percentage) / 100) }}</div>
								</td>
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

								<td class="bg-info">{{ $childWorkDoneRAQuantity }}</td>
								<td class="bg-info">{{ format_amount($childWorkDoneRAAmount) }}</td>
								<td class="bg-info">{{ $balanceWorkDoneQTY }}</td>
								<td class="bg-info">{{ format_amount($balanceWorkDoneAmount) }}</td>
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
							<tr @class(['font-weight-bold' => empty($item->units) && ($item->rate == 0 || empty($item->rate))])>
								<td rowspan={{ $itemDetailsChildCount > 0 ? $itemDetailsChildCount : 1 }}>
									{{ $itemDetailsParent->item_praposed }}</td>
								<td>{{ $itemDetailsChildFirst->name ?? '-' }}</td>
								<td>{{ $itemDetailsChildFirst->percentage ? $itemDetailsChildFirst->percentage . "%" : '-' }}
									<div class="percentage_amount">{{ !empty($itemDetailsChildFirst->percentage) ? format_amount(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100) : '' }}</div>
								</td>
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
								<td class="bg-info">{{ $itemDetailsParentworkDoneRAQuantity }}</td>
								<td class="bg-info">{{ format_amount($itemDetailsParentworkDoneRAAmount) }}</td>
								<td class="bg-info">{{ $itemDetailsParentBalanceWorkDoneRAQuantity }}</td>
								<td class="bg-info">{{ format_amount($itemDetailsParentBalanceWorkDoneRAAmount) }}</td>
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
								<tr @class(['font-weight-bold' => empty($item->units) && ($item->rate == 0 || empty($item->rate))])>
									<td>{{ $child->name }}</td>
									<td>{{ $child->percentage ? $child->percentage . '%' : '-' }}
										<div class="percentage_amount">{{ format_amount(($item->rate * $item->quantity * $child->percentage) / 100) }}</div>
									</td>
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
									<td class="bg-info">{{ $childWorkDoneRAQuantity }}</td>
									<td class="bg-info">{{ format_amount($childWorkDoneRAAmount) }}</td>
									<td class="bg-info">{{ $balanceWorkDoneQTY }}</td>
									<td class="bg-info">{{ format_amount($balanceWorkDoneAmount) }}</td>
								</tr>
							@empty
							@endforelse
							{{-- @include('reports.item-child-render', ['itemDetailChild' => $itemDetailsChildRemaining]) --}}
						@empty
						@endforelse
					@empty
					@endforelse
				</tbody>
				<tfoot>
					<tr>
						<th colspan="10">Total</th>
						<th>{{ isset($totalRate) ? format_amount($totalRate) : 0 }}</th>
						<th colspan="3"></th>
						@forelse ($workOrderRas as $workOrderRa)
							<th>{{ isset($totalByRA[$workOrderRa->id]['quantity']) ? $totalByRA[$workOrderRa->id]['quantity'] : 0 }}</th>
							<th>
								{{ isset($totalByRA[$workOrderRa->id]['amount']) ? format_amount($totalByRA[$workOrderRa->id]['amount']) : 0 }}
							</th>
						@empty
						@endforelse

						<th class="bg-info">{{ $globalTotalWorkDoneQTY }}</th>
						<th class="bg-info">{{ format_amount($globalTotalWorkDoneAmount) }}</th>
						<th class="bg-info">{{ $globalTotalBalanceWorkQTY }}</th>
						<th class="bg-info">{{ format_amount($globalTotalBalanceWorkAmount) }}</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
@endsection
@push('js')
	<script>
		function goToWorkOrder(workorder_id = null) {
			window.location.href = "{{ route('report.export') }}/" + workorder_id;
		}
	</script>
@endpush
