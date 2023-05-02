<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderItemDetail extends Model
{
    use HasFactory;

    public $fillable = [
        'item_detail_id',
        'work_order_items_id',
        'parent_id',
        'name',
        'percentage',
		'master_phase_slug'
    ];

    public function getItemPraposedAttribute() {
        return $this->name ? $this->name." ".$this->percentage."%" : $this->percentage."%";
    }

    public function ItemDetailParent() {
        return $this->belongsTo(WorkOrderItemDetail::class, 'parent_id', 'id');
    }

    public function ItemDetailChilds() {
        return $this->hasMany(WorkOrderItemDetail::class, 'parent_id', 'id');
    }
}
