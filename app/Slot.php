<?php

namespace FDA;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
