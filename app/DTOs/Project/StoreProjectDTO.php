<?php

namespace App\DTOs\Project;

use App\Http\Requests\StoreProjectRequest;

class StoreProjectDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $provider
    ){
    }

    public static function fromRequest(StoreProjectRequest $request): self
    {
        return new self (
            name: $request->input('name'),
            description: $request->input('description'),
            provider: $request->input('provider')
        );
    }
}
