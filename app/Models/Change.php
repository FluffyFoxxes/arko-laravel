<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    protected $table = "changes";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date_start',
        'date_end',
        'closed'
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
