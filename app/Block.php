<?php

namespace FDA;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $guarded = [];
    
    public function rejectUser()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }

    public function blockByUser()
    {
    	return $this->belongsTo(User::class,'blocked_by','id');
    }

     /**
     * Query scope.
     */
    public function scopeFilter($query, $filter) 
    {
        $filter->apply($query);    
    }

    public function appointmentCategory()
    {
        return $this->belongsTo(AppointmentCategory::class,'appointment_category_id','id');
    }
}
