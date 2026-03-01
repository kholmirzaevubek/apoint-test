<?php

namespace App\DTOs\Sms;

use App\Http\Requests\SmsHistoryRequest;

class SmsHistoryDTO
{
    public function __construct(
        public readonly ?string $status,
        public readonly ?string $phone,
        public readonly ?string $from,
        public readonly ?string $to,
    ) {}

    public static function fromRequest(SmsHistoryRequest $request): self
    {
        return new self(
            status: $request->input('status'),
            phone: $request->input('phone'),
            from: $request->input('from'),
            to: $request->input('to'),
        );
    }
}
