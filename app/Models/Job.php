<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table= "jobs";

    protected $fillable = [
        'user_id',
        'started_date',
        'machine_id',
        'partnumber_id',
        'active',
        'complete',
        'recorded_date',
        'qty_good',
        'qty_bad',
        'time_to_complete',
        'part_hr'
    ];

    public function machine() {
        return $this->belongsTo(Machine::class, 'machine_id', 'id');
    }

    public function part() {
        return $this->belongsTo(Part::class, 'partnumber_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
