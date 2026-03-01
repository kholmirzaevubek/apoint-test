<?php

namespace App\Jobs;

use App\Enum\SmsMessageEnum;
use App\Models\SmsMessage;
use App\Services\Sms\SmsProviderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Throwable;

class SendSmsMessage implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 10;
    public int $timeout = 60;

    public function __construct(
        private readonly int $smsMessageId
    ) {}

    public function handle(): void
    {
        $smsMessage = SmsMessage::with('project')
            ->find($this->smsMessageId);

        if (! $smsMessage) {
            return;
        }

        if ($smsMessage->status !== SmsMessageEnum::STATUS_PENDING) {
            return;
        }

        try {
            $provider = app(SmsProviderService::class)
                ->forProject($smsMessage->project);

            $result = $provider->send(
                $smsMessage->project,
                $smsMessage->phone,
                $smsMessage->message,
            );

            $status = isset($result['status'])
                ? SmsMessageEnum::from($result['status'])
                : SmsMessageEnum::STATUS_FAILED;

            $smsMessage->update([
                'status' => $status,
                'provider_message_id' => $result['provider_message_id'] ?? null,
                'provider_response' => $result['response'] ?? null,
                'sent_at' => $status === SmsMessageEnum::STATUS_SENT ? Carbon::now() : null,
                'delivered_at' => $status === SmsMessageEnum::STATUS_DELIVERED ? Carbon::now() : null,
                'failed_at' => $status === SmsMessageEnum::STATUS_FAILED ? Carbon::now() : null,
            ]);
        } catch (Throwable $exception) {
            $smsMessage->update([
                'status' => SmsMessageEnum::STATUS_FAILED,
                'provider_response' => [
                    'error' => $exception->getMessage(),
                ],
                'failed_at' => Carbon::now(),
            ]);
        }
    }
}
