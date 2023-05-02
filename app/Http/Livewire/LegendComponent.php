<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Legend;
use Illuminate\Support\Facades\Session;

class LegendComponent extends Component
{
    public $name;
    public $legend;
    public $master_phase_slug;
    public $state = [
        'name' => null
    ];

    public $rules = [
        'state.name' => 'required'
    ];
    public $validationAttributes = [
        'state.name' => 'name',
    ];

    public function mount()
    {
        if($this->legend) {
            $this->state = $this->legend->toArray();
        }
    }

    public function render()
    {
        return view('livewire.legend-component');
    }

    public function saveData()
    {
        $this->validate();

        if($this->legend) {
            $legend = $this->legend;
            Session::flash('success', 'Legend updated successfully.');
        } else {
            $legend = new Legend;
			$legend->master_phase_slug = $this->master_phase_slug;
            Session::flash('success', 'Legend added successfully.');
        }
        $legend->name = $this->state['name'];
        $legend->save();
        return redirect()->route('legend.index', $this->master_phase_slug);
    }
}
