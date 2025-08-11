<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'channel',
        'recipient',
        'subject',
        'body',
        'data',
        'status',
        'provider_message_id',
        'error',
        'sent_at',
        'delivered_at',
    ];

    protected $casts = [
        'data' => 'array',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}


