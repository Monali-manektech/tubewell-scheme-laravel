<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grampanchayat extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'blocks',
		'master_phase_slug'
    ];

    public function WorkOrders() {
        return $this->hasMany(WorkOrder::class);
    }
}
