<?php

namespace App\Services\Sms;

use App\DTOs\Sms\SendSmsDTO;
use App\DTOs\Sms\SmsHistoryDTO;
use App\Enum\SmsMessageEnum;
use App\Jobs\SendSmsMessage;
use App\Models\Project;
use App\Models\SmsMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SmsService
{
    public function send(Project $project, SendSmsDTO $dto): Collection
    {
        $now = Carbon::now();
        $messages = collect();

        foreach ($dto->phones as $phone) {
            $message = SmsMessage::create([
                'project_id' => $project->id,
                'phone' => $phone,
                'message' => $dto->message,
                'status' => SmsMessageEnum::STATUS_PENDING->value,
                'provider' => $project->provider,
                'queued_at' => $now,
            ]);

            SendSmsMessage::dispatch($message->id);

            $messages->push($message);
        }

        return $messages;
    }

    public function history(Project $project, SmsHistoryDTO $dto)
    {
        $query = SmsMessage::where('project_id', $project->id);

        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        if ($dto->phone) {
            $query->where('phone', $dto->phone);
        }

        if ($dto->from) {
            $query->whereDate('created_at', '>=', $dto->from);
        }

        if ($dto->to) {
            $query->whereDate('created_at', '<=', $dto->to);
        }

        return $query->latest()->paginate(15);
    }
}
