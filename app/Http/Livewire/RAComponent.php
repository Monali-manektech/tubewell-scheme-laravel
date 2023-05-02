<?php

namespace App\Http\Livewire;

use App\Models\RA;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class RAComponent extends Component
{
    public $state = [
        'name' => null,
        'amount' => null,
        'date' => null,
        'work_order_id' => null,
    ];
    public $workorders;
    public $ra;
	public $master_phase_slug;

    public $rules = [
        'state.name' => 'required|max:150',
        'state.amount' => 'required|numeric|decimal:0,2',
        'state.date' => 'required|date|date_format:Y-m-d',
        'state.work_order_id' => 'required',
    ];
    public $validationAttributes = [
        'state.name' => 'RA Name',
        'state.amount' => 'RA Amount',
        'state.date' => 'RA Date',
        'state.work_order_id' => 'Work Order Name',
    ];

    public function mount()
    {
        if($this->ra) {
            $this->state = $this->ra->toArray();
        }
		$this->master_phase_slug = Session::get('master_phase_slug');
        $this->workorders = WorkOrder::select('name', 'id')->where('master_phase_slug', $this->master_phase_slug)->get();
    }

    public function render()
    {
        return view('livewire.r-a-component');
    }

    public function saveData()
    {
        $this->validate();

        if($this->ra) {
            $ra = $this->ra;
            Session::flash('success', 'RA updated successfully.');
        } else {
            $ra = new RA();
			$ra->master_phase_slug = $this->master_phase_slug;
            Session::flash('success', 'RA added successfully.');
        }
        $ra->name = $this->state['name'];
        $ra->amount = $this->state['amount'];
        $ra->date = $this->state['date'];
        $ra->work_order_id = $this->state['work_order_id'];
        $ra->save();

        return redirect()->route('ra.index');
    }
}
