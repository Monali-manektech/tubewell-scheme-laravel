<div class="card">
    <form wire:submit.prevent='saveData'>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="">Name:</label>
                    <input type="text" wire:model="state.name" class="form-control" placeholder="Name">
                    @error('state.name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="">Email:</label>
                    <input type="email" wire:model="state.email" class="form-control" placeholder="Email">
                    @error('state.email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" wire:model="is_password" id="change_password">
                        <label class="form-check-label" for="change_password">Change Password</label>
                    </div>
                </div>
            </div>
            @if($is_password)
            <div class="row mb-2">
                <div class="col-md-6">
                    <label for="">Password:</label>
                    <input type="password" wire:model="password" class="form-control" placeholder="Enter new Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="">Confirm Password:</label>
                    <input type="password" wire:model="password_confirmation" class="form-control" placeholder="Confirm password">
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
