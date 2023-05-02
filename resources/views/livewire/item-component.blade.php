<div>
    <div class="row mb-2">
        <div class="col-md-6">
            <button class="ml-2 btn btn-primary" onclick="javascript:history.back()">Go Back</button>
        </div>
    </div>
    <form wire:submit.prevent="saveItem">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            @if (!$item)
                                Add a new Item
                            @else
                                Update Item
                            @endif
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="item_no">Item No:</label>
                                <input type="text" wire:model="state.item_no" class="form-control" placeholder="Item No">
                                @error('state.item_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="name">Link:</label>
                                <input type="text" wire:model="state.link" class="form-control" placeholder="Link">
                                @error('state.link')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="name">Discipline:</label>
                                <input type="text" wire:model="state.discipline" class="form-control" placeholder="Discipline">
                                @error('state.discipline')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="name">Legend:</label>
                                <select wire:model="state.legend" id="legend" class="form-control">
                                    <option value="">Select Legend</option>
                                    @foreach($legends as $legend)
                                        <option value="{{ $legend->id }}">{{ $legend->name }}</option>
                                    @endforeach
                                </select>
                                @error('state.legend')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="description">Description:</label>
                                <textarea wire:model="state.description" class="form-control" placeholder="Description" rows="4"></textarea>
                                @error('state.description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="units">Units:</label>
                                <select wire:model="state.units" class="form-control">
                                    <option value="">Select</option>
                                    @forelse ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @empty

                                    @endforelse

                                </select>
                                @error('state.units')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="rate">Quantity:</label>
                                <input type="number" step="0.01" wire:model="state.quantity" class="form-control" placeholder="Quantity">
                                @error('state.quantity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="rate">Rate per Unit:</label>
                                <input type="number" step="0.01" wire:model="state.rate" class="form-control" placeholder="Rate per Unit">
                                @error('state.rate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
							<div class="col-md-3 form-group">
								<label for="rate">Item Order:</label>
								<input type="text" wire:model="state.item_order" class="form-control" placeholder="Item Order">
								@error('state.item_order')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-success">
                                    @if (!$item)
                                        Add Item
                                    @else
                                        Update Item
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($item)
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">Payment Breakup</div>
                        <div class="card-body">

                            @for ($i = 0; $i <= 9; $i++)
                                <div class="p-3 mb-2 border">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>% of Payment allowed as per RFP</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" wire:model.defer="item_details.{{ $i }}.name" placeholder="Description">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" wire:model.defer="item_details.{{ $i }}.percentage" placeholder="Percentage">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Payment Breakup List</label>
                                        </div>
                                        @for ($j = 0; $j <= 9; $j++)
                                            <div class="col-md-6 form-group">
                                                <input type="text" class="form-control" wire:model.defer="item_details.{{ $i }}.item_detail_childs.{{ $j }}.name" placeholder="Description">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="number" class="form-control" wire:model.defer="item_details.{{ $i }}.item_detail_childs.{{ $j }}.percentage" placeholder="Percentage">
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            @endfor

                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-success">
                                        Update Item
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>
