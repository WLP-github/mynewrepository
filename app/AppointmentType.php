<?php

namespace FDA;

use Illuminate\Database\Eloquent\Model;

class AppointmentType extends Model
{
    public function typeSlots()
    {
    	return $this->hasMany(AppointmentTypeSlot::class)->with('slot');
    }
}
