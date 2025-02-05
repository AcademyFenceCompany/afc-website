<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateMarkup extends Model
{
    use HasFactory;

    protected $table = 'shipping_markup'; 

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'state',
        'markup',
    ];
}
