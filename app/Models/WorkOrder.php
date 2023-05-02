<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'grampanchayat_id',
        'date',
        'department',
        'start_date',
        'end_date',
		'master_phase_slug'
    ];

    public function GramPanchayat() {
        return $this->belongsTo(Grampanchayat::class , 'grampanchayat_id', 'id');
    }

    public function WorkOrderItems() {
        return $this->hasMany(WorkOrderItems::class , 'work_order_id', 'id');
    }

    public function RAs() {
        return $this->hasMany(RA::class, 'work_order_id');
    }
}
