<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerOrder extends Model
{
    use SoftDeletes;

    protected $table = 'customer_orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;
    protected $fillable = [
        'order_number',
        'customer_id',
        'sales_person_id',
        'order_date',
        'delivery_date',
        'status',
        'shipping_address_id',
        'billing_address_id',
        'subtotal',
        'tax_amount',
        'total',
  
    ];

    protected $dates = [
        'order_date',
        'delivery_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function salesPerson()
    {
        return $this->belongsTo(User::class, 'sales_person_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'billing_address_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
