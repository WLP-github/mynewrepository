<?php

namespace FDA;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isSuperAdmin()
    {
        return $this->role == 1 ? true : false;
    }

    public function isUser() 
    {
        return $this->role == 99 ? true : false;    
    }

    /**
     * Helper methods.
     */
    public function label() 
    {
        if ($this->role_id == 1) return 'danger';
        if ($this->role_id == 2) return 'warning';
        if ($this->role == 99) return 'info';
    }

    public function roleName() 
    {
        return collect(config('form.roles'))->firstWhere('value', $this->role)['name'];
    }

    /**
     * Query scope.
     */
    public function scopeFilter($query, $filter) 
    {
        $filter->apply($query);    
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function verifyUser()
    {
        return $this->hasOne('FDA\UserActivation');
    }

    public function roleUser(){
        return $this->belongsTo(RoleUser::class, 'role_id', 'id');
    }

}
