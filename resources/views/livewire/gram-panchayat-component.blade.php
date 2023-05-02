<div>
    <div class="row mb-2">
        <div class="col-md-6">
            <button class="ml-2 btn btn-primary" onclick="javascript:history.back()">Go Back</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        @if (!$grampanchayat)
                            Add a new Grampanchayat
                        @else
                            Update Grampanchayat
                        @endif
                    </h3>
                </div>
                <form wire:submit.prevent="saveData">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Gram Panchayat Name:</label>
                                <input type="text" wire:model="state.name" class="form-control" placeholder="Gram Panchayat Name">
                                @error('state.name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="block">Gram Panchayat Block:</label>
                                <input type="text" wire:model="state.blocks" class="form-control" placeholder="Gram Panchayat Block">
                                @error('state.blocks')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-success">
                                    @if (!$grampanchayat)
                                        Add Grampanchayat
                                    @else
                                        Update Grampanchayat
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
