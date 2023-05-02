@extends('layouts.admin.app')
@push('css')
	<style>
		.calc_amount{
			color:red;
			font-weight: 400;
		}

		#loadingDiv {
			/*display: none;*/
			position: fixed;
			top: 0px;
			right: 0px;
			width: 100%;
			height: 100%;
			background-color: rgba(255, 255, 255, 0.8);
			background-image: url({{ asset('assets/admin/images/loader.gif') }});
			background-repeat: no-repeat;
			background-position: center;
			z-index: 10000000;
			opacity: 1;

		}
	</style>
@endpush
@section('contents')

	<div id="loadingDiv">
		<h1 class="loading-content"></h1>
	</div>

	<div class="row">
		<div class="col-6">
			<button class="btn btn-primary" onclick="javascript:history.back()">Go Back</button>
		</div>
		<div class="col-6">
			<div class="form-group row" style="float: right;">
				<label for="staticEmail" class="col-sm-4 col-form-label">Legend Filter :</label>
				<div class="col-sm-8 mr-n2">
				<form action="{{route('link.items.filter.legend')}}" method="GET">
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
		</div>
		<div class="card-body" style="overflow-x:scroll">
{{--			{!! Form::open(['route' => ['work-orders.StoreLinkItems', $workOrder]]) !!}--}}
			<form method="POST" action="{{ route('work-orders.StoreLinkItems', $workOrder) }}">
				@csrf
				@method('PUT')
				<input type="hidden" name="previous_item_ids"
					   value="{{ implode(',', array_column($workOrderItems, 'item_id')) }}">
				<div class="pb-3">
					<div class="link-item-wrap">
						<button type="submit" class="btn btn-success">Link Items</button>
					</div>
				</div>
				<div class="pb-3">
					<div class="link-item-wrap">
					<label class="checkbox-label"><input type="checkbox" class="select-all"> Select All</label>
					</div>
				</div>
				<table class="table table-bordered" style="table-layout: fixed; width: max-content;">
					<thead>
					<tr>
						<th width="15">Select</th>
						<th width="30">Item Number</th>
						<th width="25">Link</th>
						<th width="30">Discipline</th>
						<th width="30">Legend</th>
						<th width="400">Item Description</th>
						<th width="25">Units</th>
						<th width="40">Subitem Counts</th>
						<th width="65">Qty</th>
						<th width="65">Rate Per Unit</th>
						<th width="40">Total Rate</th>
						<th width="40"> of Payment allowed as per RFP</th>
						<th width="60">Proposed billing Breakup
						</th>
						<th width="65">% of Payment Proposed</th>
					</tr>
					</thead>
					@if(count($shotedItems) == 0)
						<tbody>
						<tr>
							<td colspan="14" class="text-center">No Data Found</td>
						</tr>
						</tbody>
					@else
						<tbody>
						@php
							$currentParentChildCount = 0;
							$itemDetailsParentChildCount = 0;
						@endphp
						@forelse ($shotedItems as $i => $item)
							@php
								if (!$item->parent_id) {
										   $currentParentChildCount = 0;
										$itemDetailsParentChildCount = 0;

										$itemDetailsParentCount = count($item->ItemDetailsParent);
										foreach ($item->ItemDetailsParent as $itemDetailsParent) {
											$itemDetailsParentChildCount = $itemDetailsParentChildCount + $itemDetailsParent->item_detail_childs_count;
										}
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

									$count_values = array();
									$items_count = array();
									$itemDetailsParentFirstChildsRemaining = $itemDetailsParentFirst->ItemDetailChilds->filter(function ($itemDetailsChild, $key) {
										if ($key > 0) {
											return $itemDetailsChild;
										}
									});
									foreach ($itemDetailsParentFirstChildsRemaining as $a) {
										array_push($items_count , $a->item_id);
										@$count_values[$a->parent_id]++;
									}

									$workOrderItem = array_search($item->id, array_column($workOrderItems, 'item_id'));
									$workOrderItemId = !empty($workOrderItems[$workOrderItem]['item_id']) ? $workOrderItems[$workOrderItem]['item_id'] : '';
									$workOrderItemQty = !empty($workOrderItems[$workOrderItem]['quantity']) ? $workOrderItems[$workOrderItem]['quantity'] : '';
									$workOrderItemRate = !empty($workOrderItems[$workOrderItem]['rate']) ? $workOrderItems[$workOrderItem]['rate'] : '';
									$workOrderItemTotalRate = !empty($workOrderItems[$workOrderItem]['total_rate']) ? $workOrderItems[$workOrderItem]['total_rate'] : '';
									$workOrderItemDetails = !empty($workOrderItems[$workOrderItem]['item_details']) ? $workOrderItems[$workOrderItem]['item_details'] : [];
							@endphp
							<tr data-id="{{ $item->id }}" @class(['font-weight-bold' => empty($item->units) && ($item->rate == 0 || empty($item->rate)), 'tr-data-item' => true])>
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}">
									<input type="checkbox" name="items[{{ $item->id }}][select]" @checked($item->id ==
									$workOrderItemId) style="height: 25px; width: 25px;">
								</td>
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}"> {{ $item->item_no }} </td>
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}"> {{ $item->link }} </td>
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}"> {{ $item->discipline }} </td>
								@php $legend = App\Models\Legend::where('id', $item->legend)->whereNull('deleted_at')->first(); @endphp
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}"> {{ $legend->name }} </td>
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}"> {{ $item->description }} </td>
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}"> {{ $item->units }} </td>
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}"> {{ $item->child_items_count }} </td>
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}">
									<input type="number" step="0.01" class="item-quantity"
										   name="items[{{ $item->id }}][quantity]" id=""
										   value="{{ $item->id == $workOrderItemId ? $workOrderItemQty : $item->quantity }}"
										   placeholder="Quantity" {{ $item->id == $workOrderItemId ? 'disabled' : '' }}>
								</td>
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}">
									<input type="number" step="0.01" class="item-rate"
										   name="items[{{ $item->id }}][rate]" id=""
										   value="{{ $item->id == $workOrderItemId ? $workOrderItemRate : $item->rate }}"
										   placeholder="Rate" {{ $item->id == $workOrderItemId ? 'disabled' : '' }}>
								</td>
								<td rowspan="{{ $itemDetailsParentCount > 1 ? $itemDetailsParentChildCount : count($items_count) + 1 }}"
									class="item_total_rate"> {{ $item->id == $workOrderItemId ? $workOrderItemTotalRate : $item->total_rate }} </td>
								<td
									rowspan="{{ count($items_count) + 1 }}">
									{{ $itemDetailsParentFirst->item_praposed }}</td>
								<td>{{ $itemDetailsChildFirst->name ?? '-' }}</td>
								<td>
									@if ($itemDetailsChildFirst)
										@php
											$workOrderItemDetail = array_search($itemDetailsChildFirst->id, array_column($workOrderItemDetails, 'item_detail_id'));
											$workOrderDetailId = !empty($workOrderItemDetails[$workOrderItemDetail]['item_detail_id']) ? $workOrderItemDetails[$workOrderItemDetail]['item_detail_id'] : '';
											$workOrderDetailPercentage = !empty($workOrderItemDetails[$workOrderItemDetail]['percentage']) ? $workOrderItemDetails[$workOrderItemDetail]['percentage'] : '';
											$workOrderDetailDue = !empty($workOrderItemDetails[$workOrderItemDetail]['due_amount']) ? $workOrderItemDetails[$workOrderItemDetail]['due_amount'] : '';
										@endphp
										<input type="number" step="0.01" class="item-percent"
											   name="items[{{ $item->id }}][payment_proposed][{{ $itemDetailsChildFirst->id }}]"
											   value="{{ $itemDetailsChildFirst->id == $workOrderDetailId ? $workOrderDetailPercentage : $itemDetailsChildFirst->percentage }}" {{ $item->id == $workOrderItemId ? 'disabled' : '' }}>
										<div class="calc_amount item-due-amount">Due
											Amount: {{ $itemDetailsChildFirst->id == $workOrderDetailId ? $workOrderDetailDue : format_amount(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100) }}</div>
									@else
										-
									@endif
								</td>
							</tr>
							@php
								$itemDetailsParentFirstChildsRemaining = $itemDetailsParentFirst->ItemDetailChilds->filter(function ($itemDetailsChild, $key) {
									if ($key > 0) {
										return $itemDetailsChild;
									}
								});
							@endphp
							@forelse ($itemDetailsParentFirstChildsRemaining as $itemDetailsParentFirstChildRemaining)

								@php
									$workOrderItemDetail = array_search($itemDetailsParentFirstChildRemaining->id, array_column($workOrderItemDetails, 'item_detail_id'));
									$workOrderDetailId = !empty($workOrderItemDetails[$workOrderItemDetail]['item_detail_id']) ? $workOrderItemDetails[$workOrderItemDetail]['item_detail_id'] : '';
									$workOrderDetailPercentage = !empty($workOrderItemDetails[$workOrderItemDetail]['percentage']) ? $workOrderItemDetails[$workOrderItemDetail]['percentage'] : '';
									$workOrderDetailDue = !empty($workOrderItemDetails[$workOrderItemDetail]['due_amount']) ? $workOrderItemDetails[$workOrderItemDetail]['due_amount'] : '';
								@endphp

								<tr @class(['font-weight-bold' => empty($item->units) && ($item->rate == 0 || empty($item->rate))])>
									<td>{{ $itemDetailsParentFirstChildRemaining->name }}</td>
									<td>
										@if ($itemDetailsParentFirstChildRemaining)
											<input type="number" class="item-percent" step="0.01"
												   name="items[{{ $item->id }}][payment_proposed][{{ $itemDetailsParentFirstChildRemaining->id }}]"
												   value="{{ $itemDetailsParentFirstChildRemaining->id == $workOrderDetailId ? $workOrderDetailPercentage : $itemDetailsParentFirstChildRemaining->percentage }}" {{ $item->id == $workOrderItemId ? 'disabled' : '' }}>
											<div class="calc_amount item-due-amount">Due
												Amount: {{ $itemDetailsParentFirstChildRemaining->id == $workOrderDetailId ? $workOrderDetailDue : format_amount(($item->rate * $item->quantity * $itemDetailsParentFirstChildRemaining->percentage) / 100) }}</div>
										@else
											-
										@endif
									</td>
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

									$workOrderItemDetail = array_search($itemDetailsChildFirst->id, array_column($workOrderItemDetails, 'item_detail_id'));
									$workOrderDetailId = !empty($workOrderItemDetails[$workOrderItemDetail]['item_detail_id']) ? $workOrderItemDetails[$workOrderItemDetail]['item_detail_id'] : '';
									$workOrderDetailPercentage = !empty($workOrderItemDetails[$workOrderItemDetail]['percentage']) ? $workOrderItemDetails[$workOrderItemDetail]['percentage'] : '';
									$workOrderDetailDue = !empty($workOrderItemDetails[$workOrderItemDetail]['due_amount']) ? $workOrderItemDetails[$workOrderItemDetail]['due_amount'] : '';

								@endphp
								<tr @class(['font-weight-bold' => empty($item->units) && ($item->rate == 0 || empty($item->rate))])>
									<td rowspan={{ !empty($itemDetailsParent->ItemDetailChilds) ? $itemDetailsParent->ItemDetailChilds->count() : 1 }}>
										{{ $itemDetailsParent->item_praposed }}</td>
									<td>{{ $itemDetailsChildFirst->name ?? '-' }}</td>
									<td>
										@if ($itemDetailsChildFirst)
											<input type="number" class="item-percent" step="0.01"
												   name="items[{{ $item->id }}][payment_proposed][{{ $itemDetailsChildFirst->id }}]"
												   value="{{ $itemDetailsChildFirst->id == $workOrderDetailId ? $workOrderDetailPercentage : $itemDetailsChildFirst->percentage }}" {{ $item->id == $workOrderItemId ? 'disabled' : '' }}>
											<div class="calc_amount item-due-amount">Due
												Amount: {{ $itemDetailsChildFirst->id == $workOrderDetailId ? $workOrderDetailDue : format_amount(($item->rate * $item->quantity * $itemDetailsChildFirst->percentage) / 100) }}</div>
										@else
											-
										@endif
									</td>
								</tr>
								@forelse ($itemDetailsChildRemaining as $itemDetailsChild)
									@php
										$workOrderItemDetail = array_search($itemDetailsChild->id, array_column($workOrderItemDetails, 'item_detail_id'));
										$workOrderDetailId = !empty($workOrderItemDetails[$workOrderItemDetail]['item_detail_id']) ? $workOrderItemDetails[$workOrderItemDetail]['item_detail_id'] : '';
										$workOrderDetailPercentage = !empty($workOrderItemDetails[$workOrderItemDetail]['percentage']) ? $workOrderItemDetails[$workOrderItemDetail]['percentage'] : '';
										$workOrderDetailDue = !empty($workOrderItemDetails[$workOrderItemDetail]['due_amount']) ? $workOrderItemDetails[$workOrderItemDetail]['due_amount'] : '';
									@endphp
									<tr @class(['font-weight-bold' => empty($item->units) && ($item->rate == 0 || empty($item->rate))])>
										<td>{{ $itemDetailsChild->name }}</td>
										<td>
											@if ($itemDetailsChild)
												<input type="number" class="item-percent" step="0.01"
													   name="items[{{ $item->id }}][payment_proposed][{{ $itemDetailsChild->id }}]"
													   value="{{ $itemDetailsChild->id == $workOrderDetailId ? $workOrderDetailPercentage : $itemDetailsChild->percentage }}" {{ $item->id == $workOrderItemId ? 'disabled' : '' }}>
												<div class="calc_amount item-due-amount">Due
													Amount: {{ $itemDetailsChild->id == $workOrderDetailId ? $workOrderDetailDue : format_amount(($item->rate * $item->quantity * $itemDetailsChild->percentage) / 100) }}</div>
											@else
												-
											@endif
										</td>
									</tr>
								@empty
								@endforelse
							@empty
							@endforelse
						@empty
						@endforelse
						</tbody>
					@endif
				</table>
				<div class="pt-3">
					<div class="link-item-wrap">
						<button type="submit" class="btn btn-success">Link Items</button>
					</div>
				</div>
			</form>

		</div>
	</div>
@endsection
@push('js')
	<script>
		$(document).ready(function () {
			$('.link-item-wrap').css('width', $('.card-body')[0].scrollWidth);
			$('.link-item-wrap').find('button').css('position', 'sticky');
			$('.link-item-wrap').find('button').css('left', 0);
			$('.link-item-wrap').find('.checkbox-label').css('position', 'sticky');
			$('.link-item-wrap').find('.checkbox-label').css('left', 0);

			$(document).on('blur', '.item-quantity', function () {
				let $this = $(this);
				var quantity = $this.val();
				var unit_rate = $this.closest('tr').find('.item-rate').val();
				var percent = $this.closest('tr').find('.item-percent').val();
				$this.closest('tr').find('.item_total_rate').text(numberWithCommas(quantity * unit_rate));
				$this.closest('tr').find('.item-due-amount').text('Due Amount: ' + numberWithCommas((quantity * unit_rate * percent) / 100));

				var remaining_payments = $this.closest('tr').nextUntil('.tr-data-item').toArray();
				$.each(remaining_payments, function (key, value) {
					var percent = $(value).find('.item-percent').val();
					$(value).find('.item-due-amount').text('Due Amount: ' + numberWithCommas((quantity * unit_rate * percent) / 100));

				});
			})

			$(document).on('blur', '.item-rate', function () {
				let $this = $(this);
				var unit_rate = $this.val();
				var quantity = $this.closest('tr').find('.item-quantity').val();
				var percent = $this.closest('tr').find('.item-percent').val()
				$this.closest('tr').find('.item_total_rate').text(numberWithCommas(quantity * unit_rate));
				$this.closest('tr').find('.item-due-amount').text('Due Amount: ' + numberWithCommas((quantity * unit_rate * percent) / 100));


				var remaining_payments = $this.closest('tr').nextUntil('.tr-data-item').toArray();
				$.each(remaining_payments, function (key, value) {
					var percent = $(value).find('.item-percent').val();
					$(value).find('.item-due-amount').text('Due Amount: ' + numberWithCommas((quantity * unit_rate * percent) / 100));

				});
			})

			$(document).on('blur', '.item-percent', function () {
				let $this = $(this);
				var percent = $this.val();
				var quantity = $this.closest('tr').find('.item-quantity').val();
				var unit_rate = $this.closest('tr').find('.item-rate').val();

				if($this.closest('tr.tr-data-item').length) {
					$this.closest('td').find('.item-due-amount').text('Due Amount: ' + numberWithCommas((quantity * unit_rate * percent) / 100));
				} else {
					var parent_raw = $this.closest('tr').prevAll('.tr-data-item').first().toArray();
					$.each(parent_raw, function (key, value) {

						var quantity = $(value).find('.item-quantity').val();
						var unit_rate = $(value).find('.item-rate').val();
						$this.closest('td').find('.item-due-amount').text('Due Amount: ' + numberWithCommas((quantity * unit_rate * percent) / 100));
					});
				}
			})

			function numberWithCommas(number) {
				return Number(number).toLocaleString('en-IN', {
					maximumFractionDigits: 2,
					currency: 'INR'
				});


			}

			$(document).on('click', '.select-all', function () {
				if($(this).is(":checked")) {

					$("input[type='checkbox']").each(function (index, obj) {
						if(!$(obj).hasClass('.select-all')) {
							$(obj).attr('checked', 'checked');
						}
					});
				} else {
					$("input[type='checkbox']").each(function (index, obj) {
						if(!$(obj).hasClass('.select-all')) {
							$(obj).attr('checked', false);
						}
					});
				}
			});

			setTimeout(function () {
				$('#loadingDiv').hide();
			}, 3000);
		});
	</script>
@endpush
