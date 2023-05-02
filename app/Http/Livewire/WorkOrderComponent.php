<?php

namespace App\Http\Livewire;

use App\Models\Grampanchayat;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class WorkOrderComponent extends Component
{
    public $state = [
        'name' => null,
        'grampanchayat_id' => null,
        'date' => null,
        'department' => null,
        'start_date' => null,
        'end_date' => null,
    ];
    public $workOrder;
    public $master_phase_slug;
    public $gramPanchayats;
    public $rules = [
        'state.name' => 'required|max:150',
        'state.grampanchayat_id' => 'required|max:150',
        'state.department' => 'required|max:150',
        'state.start_date' => 'required|date|date_format:Y-m-d',
        'state.end_date' => 'nullable|date|date_format:Y-m-d',
        'state.date' => 'required|date|date_format:Y-m-d',
    ];

    public $validationAttributes = [
        'state.name' => 'Work Order Name',
        'state.grampanchayat_id' => 'GramPanchayat',
        'state.department' => 'Department',
        'state.start_date' => 'Starting Date',
        'state.end_date' => 'Ending Date',
        'state.date' => 'Date',
    ];

    public function mount() {
        if($this->workOrder) {
            $this->state = $this->workOrder->toArray();
        }
		$this->master_phase_slug = Session::get('master_phase_slug');
        $this->gramPanchayats = Grampanchayat::select('id','name')->where('master_phase_slug', $this->master_phase_slug)->get();
    }
    public function render()
    {
        return view('livewire.work-order-component');
    }

    public function saveData() {
        $this->validate();

        if($this->workOrder) {
            $workorder = $this->workOrder;
            Session::flash('success', 'Work Order updated successfully.');
        } else {
            $workorder = new WorkOrder();
			$workorder->master_phase_slug = $this->master_phase_slug;
            Session::flash('success', 'Work Order added successfully.');
        }

        $workorder->name = $this->state['name'];
        $workorder->grampanchayat_id = $this->state['grampanchayat_id'];
        $workorder->department = $this->state['department'];
        $workorder->start_date = $this->state['start_date'];
        $workorder->end_date = $this->state['end_date'] ? $this->state['end_date'] : null ;
        $workorder->date = $this->state['date'];
        $workorder->save();

        return redirect()->route('work-orders.index');
    }
}
