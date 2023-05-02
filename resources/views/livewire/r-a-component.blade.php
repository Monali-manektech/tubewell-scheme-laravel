<div>
    <div class="row mb-2">
        <div class="col-md-6">
            <button class="ml-2 btn btn-primary" onclick="javascript:history.back()">Go Back</button>
        </div>
    </div>
    <div class="card">
        <form wire:submit.prevent='saveData'>
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-md-3">
                        <label for="work_order">Work Order</label>
                        <select wire:model="state.work_order_id" id="work_order" class="form-control">
                            <option value="">Selet</option>
                            @forelse ($workorders as $workorder)
                                <option value="{{ $workorder->id }}">{{ $workorder->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('state.work_order_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="">RA Name</label>
                        <input type="text" wire:model="state.name" class="form-control">
                        @error('state.name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="amount">Invoice Amount</label>
                        <input type="text" wire:model="state.amount" class="form-control">
                        @error('state.amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="">RA Date</label>
                        <input type="date" wire:model="state.date" class="form-control picker">
                        @error('state.date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
</div>