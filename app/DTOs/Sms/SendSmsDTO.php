<?php

namespace App\DTOs\Sms;

use App\Http\Requests\SendSmsRequest;

class SendSmsDTO
{
    public function __construct(
        public readonly array $phones,
        public readonly string $message,
    ) {}

    public static function fromRequest(SendSmsRequest $request): self
    {
        return new self(
            phones: $request->input('phones'),
            message: $request->input('message'),
        );
    }
}
