<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'is_read',
        'admin_reply',
        'replied_by',
        'replied_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
            'is_read' => 'boolean',
            'replied_at' => 'datetime',
        ];
    }

    /**
     * Get the admin who replied.
     */
    public function replier()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}
