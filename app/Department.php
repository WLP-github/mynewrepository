<?php

namespace FDA;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function appointmentCategory()
    {
    	return $this->hasMany(AppointmentCategory::class,'department_id');
    }
}
