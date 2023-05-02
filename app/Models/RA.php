<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RA extends Model
{
    use HasFactory;
    public $fillable = [
        'name',
        'amount',
        'date',
        'work_order_id',
		'master_phase_slug'
    ];

    public function WorkOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }

    public function RADetails()
    {
        return $this->hasMany(RaDetails::class, 'r_a_id', 'id');
    }
}
