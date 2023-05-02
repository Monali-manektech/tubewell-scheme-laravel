@extends('layouts.admin.app')

@section('contents')
<div class="row mb-2">
    <div class="col-md-6">
        <button class="ml-2 btn btn-primary" onclick="javascript:history.back()">Go Back</button>
    </div>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="">Work Order</label>
                            <select name="workorder" id="workorder" class="form-control">
                                <option value="">Select</option>
                                @forelse ($workOrders as $workOrder)
                                    <option value="{{ $workOrder->id }}">{{ $workOrder->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-success" type="button" id="export">
                                View Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('click', '#export', (e) => {
            const workOrderID = $('#workorder').val();
            if(!workOrderID) {
                alert("Please select the Work Order First")
            }
            
            let reportRoute = "{{ route('report.export') }}"
            reportRoute = `${reportRoute}/${workOrderID}`
            
            window.location = reportRoute
        })
    </script>
@endpush