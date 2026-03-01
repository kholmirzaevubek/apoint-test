<?php

namespace App\Services\Sms;

use App\Enum\SmsMessageEnum;
use App\Models\Project;
use App\Models\SmsMessage;
use Illuminate\Support\Str;

class FakeProviderService implements SmsProviderServiceInterface
{
    public function send(Project $project, string $phone, string $message): array
    {
        return [
            'status' => SmsMessageEnum::STATUS_SENT->value,
            'provider_message_id' => Str::uuid()->toString(),
            'response' => [
                'provider' => 'fake',
                'message' => 'Message accepted for delivery.',
            ],
        ];
    }
}
