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
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('legend.create', $master_phase_slug) }}" class="btn btn-primary">Add New Legend</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <td>SR No.</td>
                                <td>Legend</td>
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
            const datatable = $("#table").DataTable({
                processing: true,
                responsive: true,
                pageLength: 20,
                serverSide: true,
                scrollX: true,
                ajax: "{{ route('legend.index', $master_phase_slug) }}",
                columns: [
                    {data: 'DT_RowIndex', searchable:false},
                    {data: 'name'},
                    {data: 'action'},
                ],
            });
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
