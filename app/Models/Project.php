<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'provider',
        'api_key',
    ];

    public function smsMessages()
    {
        return $this->hasMany(SmsMessage::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $project): void {
            if (empty($project->api_key)) {
                $project->api_key = Str::random(40);
            }
        });
    }

}
