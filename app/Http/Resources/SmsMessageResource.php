<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SmsMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'message' => $this->message,
            'status' => $this->status,
            'provider' => $this->provider,
            'provider_message_id' => $this->provider_message_id,
            'queued_at' => $this->queued_at,
            'sent_at' => $this->sent_at,
            'delivered_at' => $this->delivered_at,
            'failed_at' => $this->failed_at,
            'created_at' => $this->created_at,
        ];
    }
}
