<?php

namespace App\Models;

use App\Enum\SmsMessageEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SmsMessage extends Model
{
    protected $fillable = [
        'project_id',
        'phone',
        'message',
        'status',
        'provider',
        'provider_message_id',
        'provider_response',
        'queued_at',
        'sent_at',
        'delivered_at',
        'failed_at',
    ];

    protected $casts = [
        'status' => SmsMessageEnum::class,
        'provider_response' => 'array',
        'queued_at' => 'datetime',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
