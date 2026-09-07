<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'state',
        'country',
        'status',
    ];

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
}