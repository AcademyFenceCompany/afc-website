<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'ams-users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    const LEVEL_STAFF = 'Staff';
    const LEVEL_ADMIN = 'Admin';
    const LEVEL_GOD = 'God';

    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'level',
        'enabled',
        'ip_filter',
        'New'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'created',
        'lastlog'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
    public function getLastLoginAttribute()
{
    if (!$this->lastlog) {
        return 'Never logged in';
    }
    return \Carbon\Carbon::parse($this->lastlog)->format('M d, Y h:i A');
}
}