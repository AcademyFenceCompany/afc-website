<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerAddress;
use App\Models\CustomerOrder;


class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id'; // Define the primary key
    public $incrementing = true; // Ensures the primary key is auto-incrementing
    protected $keyType = 'int'; // Specifies the key type

    protected $fillable = [
        'name', 'company', 'email', 'phone', 'phone_ext',
        'alt_phone', 'alt_phone_ext', 'fax'
    ];

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id', 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(CustomerOrder::class, 'customer_id', 'customer_id');
    }
}

