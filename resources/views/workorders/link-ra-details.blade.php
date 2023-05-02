@extends('layouts.admin.app')
@push('css')
<style>
	.percentage_loading{
		display:none;
	}
	.amount_loading{
		display:none;
	}
	.calc_perc{
		color:red
	}
	.calc_amount{
		color:red;
	}
	.percentage_amount{
		color:red;
		font-weight: 400;
	}

	.sticky-col {
		position: -webkit-sticky;
		position: sticky;
		background-color: #f3f3f3;
		left: 0;
	}

	.first-col {
		width: 70px;
		min-width: 70px;
		max-width: 70px;
		left: 0;
	}

	.second-col {
		width: 130px;
		min-width: 130px;
		max-width: 130px;
		left: 70px;
	}

	.third-col {
		width: 100px;
		min-width: 100px;
		max-width: 100px;
		left: 201px;
	}

	.fourth-col {
		width: 150px;
		min-width: 150px;
		max-width: 150px;
		left: 302px;
	}
	.fifth-col {
		width: 170px;
		min-width: 170px;
		max-width: 170px;
		left: 452px;
	}
	.sixth-col {
		width: 200px;
		min-width: 200px;
		max-width: 200px;
		left: 621px;
	}


</style>
@endpush
@section('contents')
	@include('alert')

	<div class="row">
		<div class="col-6">
			<button class="btn btn-primary" onclick="javascript:history.back()">Go Back</button>
		</div>
		<div class="col-6">
			<div class="form-group row" style="float: right;">
				<label for="staticEmail" class="col-sm-4 col-form-label">Legend Filter :</label>
				<div class="col-sm-8 mr-n2">
				<form action="{{route('ra.filter.legend')}}" method="GET">
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
			@if (!isset($raID))
				<div class="row">
					<div class="col-md-4">
					</div>
					<div class="col-md-4">
						<!-- Default switch -->
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input toggle-items" id="customSwitches">
							<label class="custom-control-label" for="customSwitches">Toggle to See RA Details</label>
						</div>
					</div>
					<div class="col-md-4">
					</div>
				</div>
			@endif
		</div>

		<div class="card-body" style="overflow-x:scroll">
			@isset($raID)
				{!! Form::open(['route' => ['work-orders.StoreLinkRaDetails', $workOrder]]) !!}
				<input type="hidden" name="previous_item_ids" value="{{ implode(',', $workOrderItemsID) }}">
				<div class="pb-3">
					<div class="link-ra-wrap">
						<button type="submit" class="btn btn-success">Link RA Details</button>
					</div>
				</div>
			@endisset
			<table class="table table-bordered" style="table-layout: fixed; width: max-content">
				<thead>
					<tr>
						<th rowspan="2" class="sticky-col first-col">Select</th>
						<th rowspan="2" class="sticky-col second-col">Item Number</th>
						<th rowspan="2">Link</th>
						<th rowspan="2">Discipline</th>
						<th rowspan="2">Legend</th>
						<th rowspan="2" width="500">Item Description</th>
						<th rowspan="2">Units</th>
						<th rowspan="2">Subitem Counts</th>
						<th rowspan="2" class="sticky-col third-col">Qty</th>
						<th rowspan="2" class="sticky-col fourth-col">Rate Per Unit</th>
						<th rowspan="2" class="sticky-col fifth-col">Total Rate</th>
						<th rowspan="2" width="150">% of Payment allowed as per RFP</th>
						<th rowspan="2" width="250">Proposed billing Breakup
						<th rowspan="2" class="sticky-col sixth-col">% of Payment Proposed</th>
						@forelse ($workOrderRas as $workOrderRa)
							<th colspan="3" @class(['d-none ra_details' => !isset($raID)])>{{ $workOrderRa->name }}</th>
						@empty
						@endforelse
					</tr>
					<tr>
						@forelse ($workOrderRas as $workOrderRa)
							<th @class(['d-none ra_details' => !isset($raID)])>QTY</th>
							<th @class(['d-none ra_details' => !isset($raID)])>Percentage</th>
							<th @class(['d-none ra_details' => !isset($raID)])>Amount</th>
						@empty
						@endforelse
					</tr>
				</thead>
				@if(count($items) == 0)
				<tbody>
					<tr>
						<td colspan="14" class="text-center">No Data Found</td>
					</tr>
				</tbody>
				@else
				<tbody>
					@forelse ($items as $item)
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
						<tr data-id="{{ $item->id }}" @class([
							'font-weight-bold' =>
								empty($item->units) && ($item->rate == 0 || empty($item->rate)),
						])>
							<td rowspan="{{ $itemDetailsParentChildCount }}" class="sticky-col first-col">
								<input type="checkbox" name="item[{{ $item->item_id }}]" @checked(in_array($item->item_id, $workOrderItemsID))
									@disabled(true)>
							</td>
							<td rowspan="{{ $itemDetailsParentChildCount }}" class="sticky-col second-col"> {{ $item->item_no }} </td>
							<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->link }} </td>
							<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->discipline }} </td>
							@php $legend = App\Models\Legend::where('id', $item->legend)->whereNull('deleted_at')->first(); @endphp
							<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $legend->name }} </td>
							<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->description }} </td>
							<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->units }} </td>
							<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->child_items_count }} </td>
							<td rowspan="{{ $itemDetailsParentChildCount }}" class="sticky-col third-col"> {{ $item->quantity }} </td>
							<td rowspan="{{ $itemDetailsParentChildCount }}" class="sticky-col fourth-col"> {{ $item->formated_rate }} </td>
							<td rowspan="{{ $itemDetailsParentChildCount }}" class="sticky-col fifth-col">
								{{ $item->total_rate }} </td>
							<td
								rowspan="{{ $itemDetailsParentFirst->item_detail_childs_count > 0 ? $itemDetailsParentFirst->item_detail_childs_count : 1 }}">
								{{ $itemDetailsParentFirst->item_praposed }}</td>
							<td>{{ $itemDetailsChildFirst->name ?? '-' }}</td>
							<td class="get_payment_proposed sticky-col sixth-col">
								{{ $itemDetailsChildFirst && $itemDetailsChildFirst->percentage ? $itemDetailsChildFirst->percentage . '%' : '-' }}
								@if($itemDetailsChildFirst && $itemDetailsChildFirst->percentage)
								<div class="percentage_amount" data-amount="{{ round(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100, 2) }}">{{ format_amount(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100) }}</div>
								@endif

							</td>
							@php
								$RATotalAmount = 0;
							@endphp
							@forelse ($workOrderRas as $workOrderRa)
								@if (isset($itemDetailsChildFirst->id) && isset($raID))
									@php
										$amount = !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount']) ? $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount'] : 0;
										$RATotalAmount = $RATotalAmount + (float)$amount;

									 $disabled = !empty($workOrderRasQuantity[$itemDetailsChildFirst->id]) && !in_array($workOrderRa->id, $workOrderRasQuantity[$itemDetailsChildFirst->id]['r_a_id']) && $workOrderRasQuantity[$itemDetailsChildFirst->id]['quantity'] >= $item->quantity ? 'disabled' : ''
									@endphp
									<td><input type="number" class="quantity-row" step="0.01"  @disabled($raID != $workOrderRa->id) {{ $disabled }}
											name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsChildFirst->id }}][quantity]" data-quantity="{{ $item->quantity }}"
											value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['quantity'] ?? '' }}">
									</td>
									<td class="percent-td"><input type="number" class="percentage_row" step="0.01" @disabled($raID != $workOrderRa->id) {{ $disabled }}
											name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsChildFirst->id }}][percentage]"
											value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['percentage'] ?? '' }}">
											<div class="percentage_loading"><i class="fa fa-spinner fa-spin"></i></div>
											<div class="calc_perc"></div>
									</td>
									<td class="amount-td"><input type="number" class="amount_row" step="0.01" @disabled($raID != $workOrderRa->id) {{ $disabled }}
											name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsChildFirst->id }}][amount]"
											value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount'] ?? '' }}">
											<div class="amount_loading"><i class="fa fa-spinner fa-spin"></i></div>
											<div class="calc_amount" data-amount="{{ !empty($itemDetailsChildFirst->percentage) && !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount']) ? round(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100, 2) - $RATotalAmount : '' }}">{{ !empty($itemDetailsChildFirst->percentage) && !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount']) ? 'Due Amount: ' . format_amount(round(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100, 2) - $RATotalAmount) : '' }}</div>
									</td>
								@else
									@php
									@endphp
									<td @class(['d-none ra_details' => !isset($raID)])>
										@if ($itemDetailsChildFirst && isset($workOrderRasLink[$workOrderRa->id]))
											{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['quantity'] ?? '' }}
										@endif
									</td>
									<td @class(['d-none ra_details' => !isset($raID)])>
										@if ($itemDetailsChildFirst && isset($workOrderRasLink[$workOrderRa->id]))
											{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['percentage'] ?? '' }}
										@endif
									</td>
									<td @class(['d-none ra_details' => !isset($raID)])>
										@if ($itemDetailsChildFirst &&
										isset($workOrderRasLink[$workOrderRa->id])
										&& isset($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]))
											{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount'] ? format_amount($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount']) : '' }}
										@endif
									</td>
								@endif
							@empty
							@endforelse
						</tr>
						@php
							$itemDetailsParentFirstChildsRemaining = $itemDetailsParentFirst->ItemDetailChilds->filter(function ($itemDetailsChild, $key) {
							    if ($key > 0) {
							        return $itemDetailsChild;
							    }
							});
						@endphp
						@forelse ($itemDetailsParentFirstChildsRemaining as $itemDetailsParentFirstChildRemaining)
							<tr>
								<td>{{ $itemDetailsParentFirstChildRemaining->name }}</td>
								<td class="get_payment_proposed sticky-col sixth-col">
									{{ $itemDetailsParentFirstChildRemaining->percentage ? $itemDetailsParentFirstChildRemaining->percentage . ' %' : '-' }}
									@if($itemDetailsParentFirstChildRemaining && $itemDetailsParentFirstChildRemaining->percentage)
										<div class="percentage_amount" data-amount="{{ round(($item->rate * $item->quantity * $itemDetailsParentFirstChildRemaining->percentage) / 100, 2) }}">{{ format_amount(($item->rate * $item->quantity * $itemDetailsParentFirstChildRemaining->percentage) / 100) }}</div>
									@endif
								</td>

								@php
									$RATotalAmount = 0;
								@endphp
								@forelse ($workOrderRas as $workOrderRa)
									@if (isset($itemDetailsParentFirstChildRemaining->id) && isset($raID))
										@php
											$amount = !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['amount']) ? $workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['amount'] : 0;
											$RATotalAmount = $RATotalAmount + (float)$amount;
                                            $disabled =  !empty($workOrderRasQuantity[$itemDetailsParentFirstChildRemaining->id]) && !in_array($workOrderRa->id, $workOrderRasQuantity[$itemDetailsParentFirstChildRemaining->id]['r_a_id']) && $workOrderRasQuantity[$itemDetailsParentFirstChildRemaining->id]['quantity'] >= $item->quantity ? 'disabled' : '';
										@endphp
										<td><input type="number" class="quantity-row" step="0.01" @disabled($raID != $workOrderRa->id) {{ $disabled }}
												name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsParentFirstChildRemaining->id }}][quantity]" data-quantity="{{ $item->quantity }}"
												value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['quantity'] ?? '' }}">
										</td>
										<td class="percent-td"><input type="number" step="0.01" class="percentage_row" @disabled($raID != $workOrderRa->id) {{ $disabled }}
												name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsParentFirstChildRemaining->id }}][percentage]"
												value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['percentage'] ?? '' }}">
												<div class="percentage_loading"><i class="fa fa-spinner fa-spin"></i></div>
												<div class="calc_perc"></div>
										</td>
										<td class="amount-td"><input type="number" class="amount_row" step="0.01" @disabled($raID != $workOrderRa->id) {{ $disabled }}
												name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsParentFirstChildRemaining->id }}][amount]"
												value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['amount'] ?? '' }}">
												<div class="amount_loading"><i class="fa fa-spinner fa-spin"></i></div>
											    <div class="calc_amount" data-amount="{{ !empty($itemDetailsParentFirstChildRemaining->percentage) && !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['amount']) ? round(($item->rate * $item->quantity * $itemDetailsParentFirstChildRemaining->percentage) / 100, 2) - $RATotalAmount : '' }}">{{ !empty($itemDetailsParentFirstChildRemaining->percentage) && !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['amount']) ? 'Due Amount: ' . format_amount(round(($item->rate * $item->quantity * $itemDetailsParentFirstChildRemaining->percentage) / 100, 2) - $RATotalAmount) : '' }}</div>

										</td>
									@else
										<td @class(['d-none ra_details' => !isset($raID)])>
											{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['quantity'] ?? '' }}
										</td>
										<td @class(['d-none ra_details' => !isset($raID)])>
											{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['percentage'] ?? '' }}
										</td>
										<td @class(['d-none ra_details' => !isset($raID)])>
											@if ($itemDetailsChildFirst &&
											isset($workOrderRasLink[$workOrderRa->id]) &&
											isset($workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]))
												{{ format_amount($workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['amount']) ?? '' }}
											@endif
										</td>
									@endif
								@empty
								@endforelse
							</tr>
						@empty
						@endforelse
						@forelse ($itemDetailsParentRemaining as $itemDetailsParent)
							@php
								$itemDetailsChildCount = $itemDetailsParent->item_detail_childs_count;
								$itemDetailsChildFirst = $itemDetailsParent->ItemDetailChilds->first();

								$itemDetailsChildRemaining = $itemDetailsParent->ItemDetailChilds->filter(function ($itemDetailsChild, $key) {
								    if ($key > 0) {
								        return $itemDetailsChild;
								    }
								});
							@endphp
							<tr>
								<td rowspan={{ $itemDetailsChildCount > 0 ? $itemDetailsChildCount : 1 }}>
									{{ $itemDetailsParent->item_praposed }}</td>
								<td>{{ $itemDetailsChildFirst->name ?? '-' }}</td>
								<td class="get_payment_proposed sticky-col sixth-col">{{ $itemDetailsChildFirst->percentage ?? '0.00' }}%
									@if($itemDetailsChildFirst && $itemDetailsChildFirst->percentage)
										<div class="percentage_amount" data-amount="{{ round(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100, 2) }}">{{ format_amount(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100) }}</div>
									@endif
								</td>

								@php
									$RATotalAmount = 0;
								@endphp
								@forelse ($workOrderRas as $workOrderRa)
									@if (isset($itemDetailsChildFirst->id) && isset($raID))
										@php
											$amount = !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount']) ? $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount'] : 0;
											$RATotalAmount = $RATotalAmount + (float)$amount;
                                            $disabled =  !empty($workOrderRasQuantity[$itemDetailsChildFirst->id]) && !in_array($workOrderRa->id, $workOrderRasQuantity[$itemDetailsChildFirst->id]['r_a_id']) && $workOrderRasQuantity[$itemDetailsChildFirst->id]['quantity'] >= $item->quantity ? 'disabled' : '';
										@endphp
										<td><input type="number" class="quantity-row" step="0.01" @disabled($raID != $workOrderRa->id) {{ $disabled }}
												name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsChildFirst->id }}][quantity]" data-quantity="{{ $item->quantity }}"
												value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['quantity'] ?? '' }}">
										</td>
										<td class="percent-td"><input type="number" step="0.01" class="percentage_row" @disabled($raID != $workOrderRa->id) {{ $disabled }}
												name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsChildFirst->id }}][percentage]"
												value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['percentage'] ?? '' }}">
												<div class="percentage_loading"><i class="fa fa-spinner fa-spin"></i></div>
												<div class="calc_perc"></div>
										</td>
										<td class="amount-td"><input type="number" class="amount_row" step="0.01" @disabled($raID != $workOrderRa->id) {{ $disabled }}
												name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsChildFirst->id }}][amount]"
												value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount'] ?? '' }}">
												<div class="amount_loading"><i class="fa fa-spinner fa-spin"></i></div>
											    <div class="calc_amount" data-amount="{{ !empty($itemDetailsChildFirst->percentage) && !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount']) ? round(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100, 2) - $RATotalAmount : '' }}">{{ !empty($itemDetailsChildFirst->percentage) && !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount']) ? 'Due Amount: ' . format_amount(round(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100, 2) - $RATotalAmount) : '' }}</div>

										</td>
									@else
										<td @class(['d-none ra_details' => !isset($raID)])>
											{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['quantity'] ?? '' }}</td>
										<td @class(['d-none ra_details' => !isset($raID)])>
											{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['percentage'] ?? '' }}
										</td>
										<td @class(['d-none ra_details' => !isset($raID)])>
											@if ($itemDetailsChildFirst && isset($workOrderRasLink[$workOrderRa->id]) && isset($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]))
											{{ format_amount($workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount']) }}
											@endif
										</td>
									@endif
								@empty
								@endforelse
							</tr>
							@forelse ($itemDetailsChildRemaining as $itemDetailsChild)
								<tr>
									<td>{{ $itemDetailsChild->name }}</td>
									<td class="get_payment_proposed sticky-col sixth-col">{{ $itemDetailsChild->percentage ? $itemDetailsChild->percentage . '%' : '-' }}
										@if($itemDetailsChild && $itemDetailsChild->percentage)
											<div class="percentage_amount" data-amount="{{ round(($item->rate * $item->quantity * $itemDetailsChild->percentage) / 100, 2) }}">{{ format_amount(($item->rate * $item->quantity * $itemDetailsChild->percentage) / 100) }}</div>
										@endif
									</td>

									@php
										$RATotalAmount = 0;
									@endphp
									@forelse ($workOrderRas as $workOrderRa)
										@if (isset($itemDetailsChild->id) && isset($raID))
											@php
												$amount = !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['amount']) ? $workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['amount'] : 0;
												$RATotalAmount = $RATotalAmount + (float)$amount;
                                                $disabled =  !empty($workOrderRasQuantity[$itemDetailsChild->id]) && !in_array($workOrderRa->id, $workOrderRasQuantity[$itemDetailsChild->id]['r_a_id']) && $workOrderRasQuantity[$itemDetailsChild->id]['quantity'] >= $item->quantity ? 'disabled' : '';
											@endphp
											<td><input type="number" class="quantity-row" step="0.01" @disabled($raID != $workOrderRa->id) {{ $disabled }}
													name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsChild->id }}][quantity]" data-quantity="{{ $item->quantity }}"
													value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['quantity'] ?? '' }}">
											</td>
											<td class="percent-td"><input type="number" step="0.01" class="percentage_row" @disabled($raID != $workOrderRa->id) {{ $disabled }}
													name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsChild->id }}][percentage]"
													value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['percentage'] ?? '' }}">
													<div class="percentage_loading"><i class="fa fa-spinner fa-spin"></i></div>
													<div class="calc_perc"></div>
											</td>
											<td class="amount-td"><input type="number" class="amount_row" step="0.01" @disabled($raID != $workOrderRa->id) {{ $disabled }}
													name="ra[{{ $workOrderRa->id }}][{{ $itemDetailsChild->id }}][amount]"
													value="{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['amount'] ?? '' }}">
													<div class="amount_loading"><i class="fa fa-spinner fa-spin"></i></div>
												    <div class="calc_amount" data-amount="{{ !empty($itemDetailsChild->percentage) && !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['amount']) ? round(($item->rate * $item->quantity * $itemDetailsChild->percentage) / 100, 2) - $RATotalAmount : '' }}">{{ !empty($itemDetailsChild->percentage) && !empty($workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['amount']) ? 'Due Amount: ' . format_amount(round(($item->rate * $item->quantity * $itemDetailsChild->percentage) / 100, 2) - $RATotalAmount) : '' }}</div>

											</td>
										@else
											<td @class(['d-none ra_details' => !isset($raID)])>
												{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['quantity'] ?? '' }}</td>
											<td @class(['d-none ra_details' => !isset($raID)])>
												{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['percentage'] ?? '' }}</td>
											<td @class(['d-none ra_details' => !isset($raID)])>
												@if ($itemDetailsChild && isset($workOrderRasLink[$workOrderRa->id]) && isset($workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]))
													{{ format_amount($workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['amount']) }}</td>
												@endif
										@endif
									@empty
									@endforelse
								</tr>
							@empty
							@endforelse
						@empty
						@endforelse
					@empty
					@endforelse

					{{-- For remaining Items which are not selected in work order --}}
					{{-- @if (!isset($raID))
						@forelse ($shotedItems as $item)
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
								    $itemDetailsParentFirst = get_empty_item();
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
							<tr class="other_items" style="display: none;">
								<td rowspan="{{ $itemDetailsParentChildCount }}">
									<input type="checkbox" name="item[{{ $item->item_id }}]" @checked(in_array($item->item_id, $workOrderItemsID))
										@disabled(true)>
								</td>
								<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->item_no }} </td>
								<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->link }} </td>
								<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->discipline }} </td>
								<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->legend }} </td>
								<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->description }} </td>
								<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->units }} </td>
								<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->child_items_count }} </td>
								<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->quantity }} </td>
								<td rowspan="{{ $itemDetailsParentChildCount }}"> {{ $item->foamted_rate }} </td>
								<td rowspan="{{ $itemDetailsParentChildCount }}">
									{{ $item->total_rate }} </td>
								<td
									rowspan="{{ $itemDetailsParentFirst->item_detail_childs_count > 0 ? $itemDetailsParentFirst->item_detail_childs_count : 1 }}">
									{{ $itemDetailsParentFirst->item_praposed }}</td>
								<td>{{ $itemDetailsChildFirst->name ?? '-' }}</td>
								<td>
									{{ $itemDetailsChildFirst && $itemDetailsChildFirst->percentage ? $itemDetailsChildFirst->percentage . '%' : '-' }}
								</td>

								@forelse ($workOrderRas as $workOrderRa)
									<td>@if ($itemDetailsChildFirst){{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['quantity'] ?? '' }}@endif</td>
									<td>@if ($itemDetailsChildFirst){{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount'] ?? '' }}@endif</td>
								@empty
								@endforelse
							</tr>
							@php
								$itemDetailsParentFirstChildsRemaining = $itemDetailsParentFirst->ItemDetailChilds->filter(function ($itemDetailsChild, $key) {
								    if ($key > 0) {
								        return $itemDetailsChild;
								    }
								});
							@endphp
							@forelse ($itemDetailsParentFirstChildsRemaining as $itemDetailsParentFirstChildRemaining)
								<tr class="other_items" style="display: none;">
									<td>{{ $itemDetailsParentFirstChildRemaining->name }}</td>
									<td>
										{{ $itemDetailsParentFirstChildRemaining->percentage ? $itemDetailsParentFirstChildRemaining->percentage . ' %' : '-' }}
									</td>

									@forelse ($workOrderRas as $workOrderRa)
										<td>{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['quantity'] ?? '' }}
										</td>
										<td>{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsParentFirstChildRemaining->id]['amount'] ?? '' }}</td>
									@empty
									@endforelse
								</tr>
							@empty
							@endforelse
							@forelse ($itemDetailsParentRemaining as $itemDetailsParent)
								@php
									$itemDetailsChildCount = $itemDetailsParent->item_detail_childs_count;
									$itemDetailsChildFirst = $itemDetailsParent->ItemDetailChilds->first();

									$itemDetailsChildRemaining = $itemDetailsParent->ItemDetailChilds->filter(function ($itemDetailsChild, $key) {
									    if ($key > 0) {
									        return $itemDetailsChild;
									    }
									});
								@endphp
								<tr class="other_items" style="display: none;">
									<td rowspan={{ $itemDetailsChildCount > 0 ? $itemDetailsChildCount : 1 }}>
										{{ $itemDetailsParent->item_praposed }}</td>
									<td>{{ $itemDetailsChildFirst->name ?? '-' }}</td>
									<td>{{ $itemDetailsChildFirst->percentage ?? '0.00' }}%</td>

									@forelse ($workOrderRas as $workOrderRa)
										<td>{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['quantity'] ?? '' }}</td>
										<td>{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChildFirst->id]['amount'] ?? '' }}</td>
									@empty
									@endforelse
								</tr>
								@forelse ($itemDetailsChildRemaining as $itemDetailsChild)
									<tr class="other_items" style="display: none;">
										<td>{{ $itemDetailsChild->name }}</td>
										<td>
											{{ $itemDetailsChild->percentage ? $itemDetailsChild->percentage . '%' : '-' }}
										</td>

										@forelse ($workOrderRas as $workOrderRa)
											<td>{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id]['quantity'] ?? '' }}</td>
											<td>{{ $workOrderRasLink[$workOrderRa->id][$itemDetailsChild->id][''] ?? '' }}</td>
										@empty
										@endforelse
									</tr>
								@empty
								@endforelse
							@empty
							@endforelse
						@empty
						@endforelse
					@endif --}}
				</tbody>
				@endif
			</table>
			@isset($raID)
				<div class="pt-3">
					<div class="link-ra-wrap">
						<button type="submit" class="btn btn-success">Link RA Details</button>
					</div>
				</div>
				{!! Form::close() !!}
			@endisset
		</div>
	</div>
@endsection

@push('js')
	<script>
		var load_img = false;
		$(document).on('change', '.toggle-items', function() {
			if ($(this).is(':checked')) {
				// $(document).find('.other_items').show();
				$(document).find('.ra_details').removeClass("d-none");
			} else {
				// $(document).find('.other_items').hide();
				$(document).find('.ra_details').addClass("d-none");
			}
		})
		// $('#legend_filter').on('change', function() {
		// 	$(this).val());
		// 	"{{route('ra.filter.legend', '')}}"+"/"+legend,
		// })

		$(document).ready(function () {
			$('.link-ra-wrap').css('width', $('.card-body')[0].scrollWidth);
			$('.link-ra-wrap').find('button').css('position', 'sticky');
			$('.link-ra-wrap').find('button').css('left', 0);
		});

		$('td input.quantity-row').bind('change', function () {

			var input_quantity = $(this).val();
			var quantity = $(this).attr('data-quantity');

			if(input_quantity) {
				var percentage = ( parseFloat(input_quantity) * 100 ) / quantity;
				$(this).closest('td').next().find(".percentage_row").val(percentage);
				$(this).closest('td').next().find(".percentage_row").trigger('change');
			} else {
				$(this).closest('td').next().next().find("input.amount_row").val('');
				$(this).closest('td').next().next().find("div.calc_amount").attr('data-amount' ,'');
				$(this).closest('td').next().next().find("div.calc_amount").text('');
				$(this).closest('td').next().find('.percentage_row').val('');
			}
		})

		$('td input.percentage_row').bind('change', function () {
			// var $row = $(this).closest('tr');
			// // console.log($(this).closest('tr').find("td:eq(4) input.amount_row").val());
			// // What row index is the clicked row?
			// var row = $row.index(); // Subtract heading row
			//
			// // Does the clicked row overlap anything following?
			// var rowspan = ~~$row.find('td[rowspan]').attr('rowspan') || 0;
			//
			// // Get all rows except the heading, up to the last overlapped row
			// var $rows = $row.parent().children().slice(1, row + rowspan);
			// row--;
			// // total_rate = $row.find("td:eq(10)").text();
			// // Now see if any preceding rows overlap the clicked row
			// $rows.each(function (i) {
			// 	var $tr = $(this);
			// 	// Only check first rowspan of a row
			// 	var rowspan = ~~$tr.find('td[rowspan]').attr('rowspan') || 0;
			// 	// If the rowspan is before the clicked row but overlaps it
			// 	// Or it is a row we included after the selection
			// 	if ((i < row && ((rowspan + i) > row)) || i > row) {
			// 		$row = $row.add($tr);
			// 	}
			// });
			// var proposed_payment_part = $.trim($(this).closest('tr').find("td.get_payment_proposed").text());
			// var proposed_payment_perc = proposed_payment_part.replace('%', '');

			// var percentage = $(this).val();
			// var remove_space_total_rate = $.trim($row.find("td:eq(10)").text());
			// var remove_comma_total_rate = remove_space_total_rate.replace(/([,])+/g,'')
			// if(proposed_payment_perc != ''){
			// 	var proposed_total_rate = remove_space_total_rate.replace(/([,])+/g,'')
			// 	var remaining_amount = parseFloat(proposed_total_rate) - ((parseFloat(proposed_total_rate) / 100) * parseFloat(proposed_payment_perc));
			// 	var proposedPrice = remaining_amount.toFixed(2);
			// 	var final_percent_wise_amount = parseFloat(proposed_total_rate) - parseFloat(proposedPrice);
			// 	var total_rate = final_percent_wise_amount;
			// }else{
			// 	var total_rate = remove_space_total_rate.replace(/([,])+/g,'')
			// }
			// return console.log(total_rate);

			var percentage = $(this).val();
			var load_img = percentage === '' ? false : true;
			if(load_img == true) {
				var prevPercentage = 0;
				$.each( $(this).parent().prevAll('td').toArray(), function( key, value ) {
					if($(value).hasClass('percent-td')) {
						var percent_value = $(value).find('.percentage_row').val() ? $(value).find('.percentage_row').val() : 0
						prevPercentage = prevPercentage + parseFloat(percent_value);
					}
				});

				var total_rate = $.trim($(this).closest('tr').find("td.get_payment_proposed").find('.percentage_amount').attr('data-amount'));

				// var proposed_total_rate = remove_space_total_rate.replace(/([,])+/g,'')
				// var remaining_amount = parseFloat(proposed_total_rate) - ((parseFloat(proposed_total_rate) / 100) * parseFloat(proposed_payment_perc));
				// var proposedPrice = remaining_amount.toFixed(2);
				// var final_percent_wise_amount = parseFloat(proposed_total_rate) - parseFloat(proposedPrice);
				// var total_rate = final_percent_wise_amount;

				var total_percentage = parseFloat(percentage) + parseFloat(prevPercentage);
				var remaining_amount = parseFloat(total_rate) - ((parseFloat(total_rate) / 100) * parseFloat(total_percentage));
				var discountPrice = remaining_amount.toFixed(2);
				var final_percent_wise_amount = (parseFloat(total_rate) / 100) * parseFloat(percentage);

				var quantity = $(this).closest('td').prev().find('.quantity-row').attr('data-quantity');
				var input_quantity = (parseFloat(percentage) * parseFloat(quantity)) / 100;

				$(this).val(parseFloat(percentage).toFixed(3).slice(0,-1));
				$(this).closest('td').next().find("input.amount_row").val(final_percent_wise_amount.toFixed(2));
				$(this).closest('td').next().find("div.calc_amount").text('Due Amount: ' + numberWithCommas(remaining_amount));
				$(this).closest('td').next().find("div.calc_amount").attr('data-amount', discountPrice);
				$(this).closest('td').prev().find('.quantity-row').val(input_quantity.toFixed(3).slice(0,-1));
				$(this).closest('td').find("div.calc_perc").text('');
			}
			if(load_img == false){
				$(this).closest('td').next().find("input.amount_row").val('');
				$(this).closest('td').next().find("div.calc_amount").text('');
				$(this).closest('td').prev().find('.quantity-row').val('');
				$(this).closest('td').next().find("div.calc_amount").attr('data-amount' ,'');
			}
		});
		function numberWithCommas(number) {
			// console.log(Number(15245000.354125).toLocaleString('en'));
			// var parts = number.toString().split(".");
			// parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			return Number(number).toLocaleString('en-IN', {
				maximumFractionDigits: 2,
				currency: 'INR'
			});


		}
		// function showLoader(loader){
		// 	setTimeout(function () {
		// 		loader.css('display','block');
		// 	}, 0);
		// }
		/*$('td input.amount_row').bind('change', function () {
			// var $row = $(this).closest('tr');
			// // console.log($(this).closest('tr').find("td:eq(4) input.amount_row").val());
			// // What row index is the clicked row?
			// var row = $row.index(); // Subtract heading row
			//
			// // Does the clicked row overlap anything following?
			// var rowspan = ~~$row.find('td[rowspan]').attr('rowspan') || 0;
			//
			// // Get all rows except the heading, up to the last overlapped row
			// var $rows = $row.parent().children().slice(1, row + rowspan);
			// row--;
			// // total_rate = $row.find("td:eq(10)").text();
			// // Now see if any preceding rows overlap the clicked row
			// $rows.each(function (i) {
			// 	var $tr = $(this);
			// 	// Only check first rowspan of a row
			// 	var rowspan = ~~$tr.find('td[rowspan]').attr('rowspan') || 0;
			// 	// If the rowspan is before the clicked row but overlaps it
			// 	// Or it is a row we included after the selection
			// 	if ((i < row && ((rowspan + i) > row)) || i > row) {
			// 		$row = $row.add($tr);
			// 	}
			// });
			// var proposed_payment_part = $.trim($(this).closest('tr').find("td.get_payment_proposed").text());
			// var proposed_payment_perc = proposed_payment_part.replace('%', '');
			// var amount = $(this).val();
			// var remove_space_total_rate = $.trim($row.find("td:eq(10)").text());
			// var remove_comma_total_rate = remove_space_total_rate.replace(/([,])+/g,'')
			// if(proposed_payment_perc != ''){
			// 	var proposed_total_rate = remove_space_total_rate.replace(/([,])+/g,'')
			// 	var remaining_amount = parseFloat(proposed_total_rate) - ((parseFloat(proposed_total_rate) / 100) * parseFloat(proposed_payment_perc));
			// 	var proposedPrice = remaining_amount.toFixed(2);
			// 	var final_percent_wise_amount = parseFloat(proposed_total_rate) - parseFloat(proposedPrice);
			// 	var total_rate = final_percent_wise_amount;
			// }else{
			// 	var total_rate = remove_space_total_rate.replace(/([,])+/g,'')
			// }
			var amount = $(this).val();
			var load_img = amount === '' ? false : true;

			if(load_img == true) {
				// var calcPerc = parseFloat(parseFloat(amount, 10) * 100)/ parseFloat(total_rate, 10);
				// var perc = parseFloat(calcPerc);
				// var remainingPerc = 100 - perc;
				// var dueAmount = total_rate - amount;

				var prevPercentage = 100;
				$.each( $(this).parent().prev().prevAll('td').toArray(), function( key, value ) {
					if($(value).hasClass('percent-td')) {
						var percent_value = $(value).find('.percentage_row').val() ? $(value).find('.percentage_row').val() : 0
						prevPercentage = prevPercentage - parseFloat(percent_value);
					}
				});


				var total_rate = $.trim($(this).closest('tr').find("td.get_payment_proposed").find('.percentage_amount').attr('data-amount'));
				var calcPerc = parseFloat(parseFloat(amount, 10) * 100)/ parseFloat(total_rate, 10);
				var perc = parseFloat(calcPerc);
				var remainingPerc = prevPercentage - perc;
				var dueAmount = total_rate - amount;

				// var loader = $(this).closest('tr').find("td div.amount_loading");
				// showLoader(loader);
				// $(this).closest('tr').find("td div.amount_loading").css('display','none');
				$(this).closest('td').prev().find("input.percentage_row").val(perc.toFixed(2));
				$(this).closest('td').prev().find("div.calc_perc").text('Due Percentage: ' + remainingPerc.toFixed(2) + "%");
				$(this).closest('td').find("div.calc_amount").attr('data-amount', dueAmount.toFixed(2));
				$(this).closest('td').find("div.calc_amount").text('');
			}
			if(load_img == false){
				// $(this).closest('td').prev().find("div.amount_loading").css('display','none');
				$(this).closest('td').prev().find("input.percentage_row").val('');
				$(this).closest('td').prev().find("div.calc_perc").text('');
			}
		});*/
	</script>
@endpush
