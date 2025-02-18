<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    public $timestamps = false;
    
    protected $primaryKey = 'customer_address_id';
    
    protected $fillable = [
        'customer_id',
        'original_customer_id',
        'original_address_id',
        'address_1',
        'address_2',
        'address_name',
        'city',
        'state',
        'zipcode',
        'billing_flag',
        'shipping_flag',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
    
    public function orders()
    {
        return $this->hasMany(CustomerOrder::class, 'billing_address_id', 'customer_address_id');
    }
}
