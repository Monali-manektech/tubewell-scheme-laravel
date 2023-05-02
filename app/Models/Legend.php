<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Legend extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['name', 'master_phase_slug'];
}
