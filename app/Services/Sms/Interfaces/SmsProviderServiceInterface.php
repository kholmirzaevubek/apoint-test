<?php

namespace App\Services\Sms;

use App\Models\Project;

interface SmsProviderServiceInterface
{
    public function send(Project $project, string $phone, string $message): array;
}
