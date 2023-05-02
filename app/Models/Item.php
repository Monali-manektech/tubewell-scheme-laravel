<?php

namespace App\Models;

use App\Traits\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, Helper;

    protected $fillable = [
        'item_no',
        'parent_id',
        'link',
        'discipline',
        'legend',
        'description',
        'quantity',
        'units',
        'rate',
        'item_order',
		'master_phase_slug'
    ];

     /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
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
        return $this->hasMany(Item::class, 'parent_id');
    }

    public function itemDetails(){
        return $this->hasMany(ItemDetail::class);
    }

    public function ItemDetailsParent(){
        return $this->hasMany(ItemDetail::class)->whereNull('parent_id');
    }

    public function itemChild(){
        return $this->hasMany(Item::class, 'parent_id', 'id');
    }

    public function Unit(){
        return $this->belongsTo(Unit::class, 'units');
    }
}
