<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'parent_id',
        'name',
        'percentage',
		'master_phase_slug'
    ];

    public function getItemPraposedAttribute() {
        return $this->name ? $this->name." ".$this->percentage."%" : $this->percentage."%";
    }

    public function ItemDetailParent() {
        return $this->belongsTo(ItemDetail::class, 'parent_id', 'id');
    }

    public function ItemDetailChilds() {
        return $this->hasMany(ItemDetail::class, 'parent_id', 'id');
    }

}
