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
                        @if ($item_id)
                            <div class="col-md-4">
                                <h5>Item No: {{ $item->item_no ?? '' }}</h5>
                            </div>
                        @else
                            <div class="col-6">
                                <div class="form-group row" style="float: left;">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Legend Filter :</label>
                                    <div class="col-sm-8 ml-n3">
                                        <select id="legend_filter" class="form-control" style="width: 250px;" id="legend_filter">
                                            <option value="">Select Legend</option>
                                            @foreach($legends as $legend)
                                                <option value="{{$legend->id}}">{{$legend->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <a style="float: right;" href="{{ route('items.create', $master_phase_slug) }}" class="btn btn-primary">Add New item</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <td>SR No.</td>
                                <td>Item No.</td>
                                <td>Link</td>
                                <td>Discipline</td>
                                <td>Legend</td>
                                <td>Description</td>
                                <td>Quantity</td>
                                <td>Units</td>
                                <td>Rate</td>
                                <td>Sub Item Count</td>
                                <td>Action</td>
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
        $(function () {
            var datatable = $("#table").DataTable({
                processing: true,
                responsive: true,
                pageLength: 20,
                lengthMenu: [
                    [10, 20, 40, 80, -1],
                    [10, 20, 40, 80, "All"]
                ],
                serverSide: true,
                scrollX: true,
                ajax: "{{ route('items.index', [$master_phase_slug, $item_id]) }}",
                columnDefs: [{ orderable: false, targets: [0, 10] }],
                columns: [
                    {data: 'DT_RowIndex', searchable:false},
                    {data: 'item_no'},
                    {data: 'link'},
                    {data: 'discipline'},
                    {data: 'legend'},
                    {data: 'description'},
                    {data: 'quantity'},
                    {data: 'units'},
                    {data: 'rate'},
                    {data: 'subitem_count'},
                    {data: 'action'},
                ],
            });

            $('#legend_filter').on('change', function(){
                var legend = $(this).val();
                datatable.clear().destroy();
                datatable = $('#table').DataTable( {
                    processing: true,
                    responsive: true,
                    pageLength: 20,
                    lengthMenu: [
                        [10, 20, 40, 80, -1],
                        [10, 20, 40, 80, "All"]
                    ],
                    serverSide: true,
                    scrollX: true,
                    ajax: "{{route('items.filter.legend', '')}}"+"/"+legend,
                    columnDefs: [{ orderable: false, targets: [0, 10] }],
                    columns: [
                        {data: 'DT_RowIndex', searchable:false},
                        {data: 'item_no'},
                        {data: 'link'},
                        {data: 'discipline'},
                        {data: 'legend'},
                        {data: 'description'},
                        {data: 'quantity'},
                        {data: 'units'},
                        {data: 'rate'},
                        {data: 'subitem_count'},
                        {data: 'action'},
                    ],
                });
            })
        });

        $(document).on('click' ,'.delete',function(e){
            e.preventDefault()
            const confirmation = confirm('Are you sure you want to remove the record? The action can not be undo.');
            if(confirmation) {
                const id = $(this).data('id');
                $(`#item-form-${id}`).submit();
            }
        })


    </script>
@endpush
