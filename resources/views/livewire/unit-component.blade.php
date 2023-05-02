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
                    <div class="col-md-6">
                        <label for="name">Name</label>
                        <input type="text" wire:model="state.name" class="form-control">
                        @error('state.name')
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