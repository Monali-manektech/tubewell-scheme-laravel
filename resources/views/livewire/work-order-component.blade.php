<div>
    <div class="row mb-2">
        <div class="col-md-6">
            <button class="ml-2 btn btn-primary" onclick="javascript:history.back()">Go Back</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header d-flex">
                    <h3 class="card-title">
                        @if (!$workOrder)
                            Add a new Workorder
                        @else
                            Update Workorder
                        @endif
                    </h3>
                </div>
                <form wire:submit.prevent="saveData">
                    <div class="card-body">

                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="name">Work Order Name:</label>
                                <input type="text" class="form-control" id="name"  wire:model="state.name">
                                @error('state.name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="grampanchayat_id">GramPanchayat Name:</label>
                                <select wire:model="state.grampanchayat_id" id="grampanchayat_id" class="form-control">
                                    <option value="">Select</option>
                                    @forelse ($gramPanchayats as $gramPanchayat)
                                        <option value="{{ $gramPanchayat->id }}">{{ $gramPanchayat->name }}</option>
                                    @empty

                                    @endforelse
                                </select>
                                @error('state.grampanchayat_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="date">Date:</label>
                                <input type="date" class="form-control picker" id="date"  wire:model="state.date">
                                @error('state.date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="department">Department:</label>
                                <input type="text" class="form-control" id="department"  wire:model="state.department">
                                @error('state.department')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="start_date">Work Start Date:</label>
                                <input type="date" class="form-control picker" id="start_date"  wire:model="state.start_date">
                                @error('state.start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="end_date">Work End Date:</label>
                                <input type="date" class="form-control picker" id="end_date"  wire:model="state.end_date">
                                @error('state.end_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-success">
                                    @if (!$workOrder)
                                        Add Workorder
                                    @else
                                        Update Workorder
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
