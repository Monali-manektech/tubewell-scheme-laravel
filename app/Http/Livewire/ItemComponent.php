<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\ItemDetail;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use App\Models\Legend;

class ItemComponent extends Component
{
    public $item;
	public $master_phase_slug;
    public $units;
    public $parent_id;
    public $legends;

    public $state = [
        'item_no' => null,
        'item_order' => null,
        'parent_id' => null,
        'link' => null,
        'discipline' => null,
        'legend' => null,
        'description' => null,
        'quantity' => 1,
        'units' => null,
        'rate' => 0
    ];

    public $item_details = [];

    public $rules = [
        'state.item_no' => 'required',
        'state.item_order' => 'required',
        'state.description' => 'required',
        'state.quantity' => 'required',
        'state.rate' => 'required|numeric|decimal:0,2',
        'state.legend' => 'required'
    ];

    public $validationAttributes = [
        'state.item_no' => 'Item No',
        'state.item_order' => 'Item Order',
        'state.link' => 'link',
        'state.discipline' => 'discipline',
        'state.legend' => 'legend',
        'state.description' => 'description',
        'state.quantity' => 'quantity',
        'state.units' => 'units',
        'state.rate' => 'rate'
    ];

    public function mount() {
        $this->units = Unit::where('master_phase_slug', $this->master_phase_slug)->get();

        if($this->item) {
            $this->state = collect($this->item)->except(['created_at', 'updated_at'])->toArray();

            $itemDetails = ItemDetail::
                            where(['item_id' => $this->item->id, 'parent_id' => null])
				  			->where('master_phase_slug', $this->master_phase_slug)
                            ->with(['ItemDetailChilds' => function ($query) {
                                return $query->orderBy('created_at');
                            }])
                            ->orderBy('created_at')
                            ->get();
            $this->item_details = collect($itemDetails)->toArray();
        }else{
            $this->state['parent_id'] = $this->parent_id;
        }
        $this->legends = Legend::whereNull('deleted_at')->where('master_phase_slug', $this->master_phase_slug)->get();
    }

    public function saveItem() {
        $this->validate();

        if($this->item){
            $this->state['units'] = $this->state['units'] ? $this->state['units'] : null;

            Item::where('id', $this->item->id)->update($this->state);
            if(isset($this->item_details) && !empty($this->item_details)){

                foreach(array_reverse($this->item_details) as $value) {
                    if(!empty($value['percentage'])){
                        $itemArray = $this->itemDetailArray($value, $this->item->id, $this->item->master_phase_slug);
                        $item_response = $this->storeData($itemArray, $value['id'] ?? null);

                        if(isset($value['item_detail_childs']) && count($value['item_detail_childs']) > 0){
                            foreach(array_reverse($value['item_detail_childs']) as $item_detail_child){

                                if(isset($item_detail_child['name']) && isset($item_detail_child['percentage']) && $item_detail_child['percentage'] != ''){
                                    $itemChildArray = $this->itemDetailArray($item_detail_child, $this->item->id, $this->item->master_phase_slug, $item_response->id);
                                    $this->storeData($itemChildArray, $item_detail_child['id'] ?? null);
                                } else {
                                    if(!empty($item_detail_child['id'])) {
                                        ItemDetail::where('id', $item_detail_child['id'])->delete();
                                    }
                                }

                            }
                        }
                    } else {
                        if(!empty($value['id'])) {
                            ItemDetail::where('parent_id', $value['id'])->orWhere('id', $value['id'])->delete();
                        }
                    }
                }
            }
            Session::flash('success','Item updated successfully.');
        }else{
			$this->state['master_phase_slug'] = $this->master_phase_slug;
            $item = Item::create($this->state);
			Session::flash('success','Item added successfully.');
            return redirect()->route('items.edit', [$this->master_phase_slug, $item->id]);
        }

        return redirect()->route('items.index', $this->master_phase_slug);
    }

    public function render()
    {
        return view('livewire.item-component');
    }

    private function itemDetailArray($itemDetails , $itemID, $master_phase_slug, $parentID = null) {
        return [
            'master_phase_slug' => $master_phase_slug ?? '',
            'name' => $itemDetails['name'] ?? '',
            'percentage' => $itemDetails['percentage'] ?? '',
            'parent_id' => $parentID,
            'item_id' => $itemID
        ];
    }

    private function storeData($array , $id = null) {
        return ItemDetail::updateOrCreate(['id' => $id], $array);
    }
}
