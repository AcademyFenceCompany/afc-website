<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    protected $table = 'users'; // Link the model to the existing table
    protected $primaryKey = 'user_id'; // Specify the primary key
    public $timestamps = false; // Disable timestamps if not in your table
    protected $fillable = ['username', 'password', 'firstname', 'lastname', 'level', 'enabled']; // Add other columns here
}
