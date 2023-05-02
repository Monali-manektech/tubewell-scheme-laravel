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
                <div class="card-header d-flex">
                    <a href="{{ route('units.create', $master_phase_slug) }}" class="ml-auto btn btn-primary">Add New Unit</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <td>
                                    SR No.
                                </td>
                                <td>
                                    Name
                                </td>
                                <td>
                                    Actions
                                </td>
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
        $(function() {
            const table = $("#table").DataTable({
                processing: true,
                responsive: true,
                pageLength: 20,
                lengthMenu: [
                    [10, 20, 40, 80, -1],
                    [10, 20, 40, 80, "All"]
                ],
                serverSide: true,
                scrollX: true,
                ajax: "{{ route('units.index', $master_phase_slug) }}",
                columns: [{
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            })
        });
        $(document).on('click' ,'.delete',function(e){
            e.preventDefault()
            const confirmation = confirm('Are you sure you want to remove the data? The action can not be undo.');
            if(confirmation) {
                const id = $(this).data('id');
                $(`#unit-form-${id}`).submit();
            }
        })
    </script>
@endpush
