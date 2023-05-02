<?php

namespace App\Models;

use App\Traits\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderItems extends Model
{
    use HasFactory, Helper;

    public $fillable = [
        'work_order_id',
        'item_id',
        'item_no',
        'item_order',
        'parent_id',
        'link',
        'discipline',
        'legend',
        'description',
        'units',
        'quantity',
        'rate',
		'master_phase_slug'
    ];

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getFormatedRateAttribute() {
        return $this->formatAmount($this->rate);
    }
    public function getTotalRateAttribute() {
        return $this->formatAmount($this->rate*$this->quantity);
    }

    public function ChildItems(){
        return $this->hasMany(WorkOrderItems::class, 'parent_id');
    }

    public function itemDetails(){
        return $this->hasMany(WorkOrderItemDetail::class, 'work_order_items_id');
    }

    public function ItemDetailsParent(){
        return $this->hasMany(WorkOrderItemDetail::class, 'work_order_items_id')->whereNull('parent_id');
    }

    public function itemChild(){
        return $this->hasMany(WorkOrderItems::class, 'parent_id', 'id');
    }

    public function Item() {
        return $this->belongsTo(Item::class);
    }

    public function Unit(){
        return $this->belongsTo(Unit::class, 'units');
    }
}
