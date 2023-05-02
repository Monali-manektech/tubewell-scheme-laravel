<?php

namespace App\Http\Livewire;

use App\Models\Grampanchayat;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class GramPanchayatComponent extends Component
{
    public $grampanchayat;
    public $master_phase_slug;
    public $state = [
        'name' => null,
        'blocks' => null,
    ];

    public $rules = [
        'state.name' => 'required|max:150',
        'state.blocks' => 'required|max:150',
    ];

    public $validationAttributes  = [
        'state.name' => 'Name',
        'state.blocks' => 'Block',
    ];

    public function mount() {
        if($this->grampanchayat) {
            $this->state = $this->grampanchayat->toArray();
        }
    }
    public function render()
    {
        return view('livewire.gram-panchayat-component');
    }

    public function saveData() {
        $this->validate();

        if($this->grampanchayat) {
            $grampanchayat = $this->grampanchayat;
            Session::flash('success', 'Grampanchayat updated successfully.');
        } else {
            $grampanchayat = new Grampanchayat;
			$grampanchayat->master_phase_slug = $this->master_phase_slug;
            Session::flash('success', 'Grampanchayat added successfully.');
        }
        $grampanchayat->name = $this->state['name'];
        $grampanchayat->blocks = $this->state['blocks'];
        $grampanchayat->save();

        return redirect()->route('gram-panchayats.index', $this->master_phase_slug);
    }
}
