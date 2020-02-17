<?php

namespace FDA;

use Illuminate\Database\Eloquent\Model;

class AppointmentTypeSlot extends Model
{
    public function slot()
    {
    	return $this->belongsTo(Slot::class,'slot_id','id');
    }
}
