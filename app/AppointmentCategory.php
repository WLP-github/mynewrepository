<?php

namespace FDA;

use Illuminate\Database\Eloquent\Model;

class AppointmentCategory extends Model
{
    public function appointmentTypes()
    {
    	return $this->hasMany(AppointmentType::class);
    }

    public function appointment(){
        return $this->hasMany(Appointment::class);
    }
}
