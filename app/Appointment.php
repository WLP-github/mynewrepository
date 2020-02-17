<?php

namespace FDA;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function appointmentCategory(){
        return $this->belongsTo(AppointmentCategory::class, 'appointment_category_id');
    }

    public function appUser()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }
}
