<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersChange extends Model
{
    protected $table = "orders_change";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'change_id',
        'order_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
