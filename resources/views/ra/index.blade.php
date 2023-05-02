@extends('layouts.admin.app')

@section('contents')
	@include('_datatable-assets')
	@include('alert')
	<div class="row mb-2">
		<div class="col-md-6">
			<button class="ml-2 btn btn-primary" onclick="javascript:history.back()">Go Back</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="row mb-n3">
						<div class="col-8">
							<div class="form-group row" style="float: left;">
								<label for="staticEmail" class="col-sm-5 col-form-label">Master Phase Filter :</label>
								<div class="col-sm-7 ml-n3">
									<select id="master_phase_filter" class="form-control" style="width: 250px;">
										@foreach($master_phases as $master_phase)
											<option value="{{ $master_phase->slug }}" {{ $master_phase->slug == $master_phase_slug ? 'selected' : '' }}>{{$master_phase->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="col-4">
							<a style="float: right;" href="{{ route('ra.create') }}" class="btn btn-primary">Add New RA</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-bordered" id="table" style="width: 100%">
						<thead>
							<tr>
								<td>ID</td>
								<td>SR NO.</td>
								<td>RA Name</td>
								<td>Work Order Name</td>
								<td>Invoice Amount</td>
								<td>Items Amount</td>
								<td>RA Date</td>
								<td>Actions</td>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<script>

		var master_phase = $('#master_phase_filter').val();
		var datatable = '';

		raDataTable(master_phase);

		function raDataTable(master_phase) {
			datatable = $("#table").DataTable({
				processing: true,
				responsive: true,
				pageLength: 20,
				"order": [
					[0, 'desc']
				],
				lengthMenu: [
					[10, 20, 40, 80, -1],
					[10, 20, 40, 80, "All"]
				],
				serverSide: true,
				scrollX: true,
				ajax: "{{ route('ra.index', $workOrderID) }}" + "?master_phase=" + master_phase ,
				columns: [{
					data: 'id',
					name: 'id',
					searchable: false,
					visible: false
				}, {
					data: 'DT_RowIndex',
					name: 'DT_RowIndex',
					searchable: false,
					orderable: false,
				},
					{
						data: 'name',
						name: 'name'
					},
					{
						data: 'work_order_id',
						name: 'work_order_id'
					},
					{
						data: 'amount',
						name: 'amount'
					},
					{
						data: 'item_amount',
						name: 'item_amount',
						sortable: false,
						searchable: false,
					},
					{
						data: 'date',
						name: 'date'
					},
					{
						data: 'action',
						name: 'action',
						orderable: false,
						searchable: false
					},
				]
			})
		}

		$('#master_phase_filter').on('change', function(){
			master_phase = $(this).val();
			datatable.clear().destroy();
			raDataTable(master_phase);
		});

		$(document).on('click', '.delete', function(e) {
			e.preventDefault()
			const confirmation = confirm('Are you sure you want to remove the data? The action can not be undo.');
			if (confirmation) {
				const id = $(this).data('id');
				$(`#ra-form-${id}`).submit();
			}
		})
	</script>
@endpush
