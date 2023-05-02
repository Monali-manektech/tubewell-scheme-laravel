<div class="card">
    <form wire:submit.prevent='saveData'>
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="name">Name:</label>
                    <input type="text" wire:model="state.name" class="form-control" placeholder="Please enter legend name">
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
