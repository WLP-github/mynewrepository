<?php

namespace FDA;

use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    public function user()
    {
        return $this->belongsTo('FDA\User', 'user_id');
    }
}
