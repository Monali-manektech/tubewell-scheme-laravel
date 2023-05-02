@extends('layouts.admin.app')
@section('contents')
    @include('_datatable-assets')
	@foreach($master_phase_wise_states as $state)
	<h4 class="m-0">{{ $state['name'] }}</h4>
    <div class="row">
        <div class="col-lg-3 col-4">

            <div class="small-box bg-success">
                <div class="inner">
                    <h2>{{ $state['work_order'] }}</h2>
                    <p>Total Work Orders</p>
                </div>
                <a href="{{ route('work-orders.index') . '?master_phase=' . $state['master_phase_slug'] }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-4">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h2>{{ $state['paid_amount'] }}</h2>
                    <p>Paid Amount</p>
                </div>
                <a href="{{ route('work-orders.index') . '?master_phase=' . $state['master_phase_slug'] }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-4">

            <div class="small-box bg-danger">
                <div class="inner">
                    <h2>{{ $state['remaining_amount'] }}</h2>
                    <p>Remaining Amount</p>
                </div>
                <a href="{{ route('work-orders.index') . '?master_phase=' . $state['master_phase_slug'] }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-4">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h2>{{ $state['remaining_amount_percent'] }}<sup style="font-size: 20px">%</sup></h2></h2>
                    <p>Remaining Amount %</p>
                </div>
                <a href="{{ route('work-orders.index') . '?master_phase=' . $state['master_phase_slug'] }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Quick Information</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" data-id="{{ $state['master_phase_slug'] }}" id="table-{{ $state['master_phase_slug'] }}" style="width: 100%">
                        <thead>
                            <tr>
                                <td>SR No.</td>
                                <td>WorkOrder Name</td>
                                <td>Total Items(n)</td>
                                <td>Total Amount</td>
                                <td>Paid Amount</td>
                                <td>Remaining Amount</td>
                                <td>Remaining %</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
	@endforeach
@endsection

@push('js')
    <script>

		$(document).ready(function () {

			$.each($('.table-bordered').toArray(), function (key, value) {

				var tableId = $(value).attr('id');
				var master_phase = $(value).attr('data-id');
				$("#" + tableId).DataTable({
					processing: true,
					responsive: true,
					pageLength: 20,
					lengthMenu: [
						[10, 20, 40, 80, -1],
						[10, 20, 40, 80, "All"]
					],
					serverSide: true,
					scrollX: true,
					ajax: "{{ route('work-orders.index') }}" + "?master_phase=" + master_phase ,
					columns: [
						{data: 'id', name: 'id'},
						{data: 'name', name: 'name'},
						{data: 'items', name: 'items', searchable: false, sortable: false},
						{data: 'total_amount', name: 'total_amount', searchable: false, sortable: false},
						{data: 'paid_amount', name: 'paid_amount', searchable: false, sortable: false},
						{data: 'remaining_amount', name: 'remaining_amount', searchable: false, sortable: false},
						{
							data: 'remaining_amount_percentage',
							name: 'remaining_amount_percentage',
							searchable: false,
							sortable: false
						},
					],
				});
			});
		})
        {{--$(function () {--}}
        {{--    const datatable = $("#table").DataTable({--}}
        {{--        processing: true,--}}
        {{--        responsive: true,--}}
        {{--        pageLength: 20,--}}
        {{--        lengthMenu: [--}}
        {{--            [10, 20, 40, 80, -1],--}}
        {{--            [10, 20, 40, 80, "All"]--}}
        {{--        ],--}}
        {{--        serverSide: true,--}}
        {{--        scrollX: true,--}}
        {{--        ajax: "{{ route('work-orders.index') }}",--}}
        {{--        columns: [--}}
        {{--            {data: 'id', name: 'id'},--}}
        {{--            {data: 'name', name: 'name'},--}}
        {{--            {data: 'items', name: 'items', searchable:false, sortable: false},--}}
        {{--            {data: 'total_amount', name: 'total_amount', searchable:false, sortable: false},--}}
        {{--            {data: 'paid_amount', name: 'paid_amount', searchable:false, sortable: false},--}}
        {{--            {data: 'remaining_amount', name: 'remaining_amount', searchable:false, sortable: false},--}}
        {{--            {data: 'remaining_amount_percentage', name: 'remaining_amount_percentage', searchable:false, sortable: false},--}}
        {{--        ],--}}
        {{--    });--}}
        {{--});--}}
    </script>
@endpush
