<?php

namespace FDA;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $guarded = [];

    public function AppCatName(){
        return $this->belongsTo(AppointmentCategory::class, 'appointment_category_id');
    }

    public function TimeSlot(){
        return $this->belongsTo(Slot::Class, "slot_id");
    }
}
