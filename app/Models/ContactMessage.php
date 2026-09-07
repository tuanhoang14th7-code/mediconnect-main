<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $table = 'contact_messages';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    public function resolvedBy()
    {
        return $this->belongsTo(
            User::class,
            'resolved_by_user_id'
        );
    }
}