<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaDetails extends Model
{
    use HasFactory;

    public $fillable = [
        'work_order_item_detail_id',
        'work_order_id',
        'r_a_id',
        'quantity',
        'percentage',
        'amount',
		'master_phase_slug'
    ];
}
