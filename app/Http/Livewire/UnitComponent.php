<?php

namespace App\Http\Livewire;

use App\Models\Unit;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class UnitComponent extends Component
{
    public $state = [
        'name' => null
    ];

    public $unit;
	public $master_phase_slug;
    public $rules = [
        'state.name' => 'required|max:150'
    ];
    public $validationAttributes = [
        'state.name' => "Name"
    ];

    public function mount()
    {
        if ($this->unit) {
            $this->state = $this->unit->toArray();
        }
    }

    public function render()
    {
        return view('livewire.unit-component');
    }

    public function saveData()
    {
        $this->validate();
        $unit = $this->unit;
        Session::flash('success', 'Unit updated successfully.');

        if(!$this->unit) {
            $unit = new Unit();
			$unit->master_phase_slug = $this->master_phase_slug;
            Session::flash('success', 'Unit added successfully.');
        }
        $unit->name = $this->state['name'];
        $unit->save();

        return redirect()->route('units.index', $this->master_phase_slug);
    }
}
