<?php

namespace App\DTOs\Project;

use App\Http\Requests\UpdateProjectRequest;

class UpdateProjectDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $provider
    ){
    }

    public static function fromRequest(UpdateProjectRequest $request): self
    {
        return new self (
            name: $request->input('name'),
            description: $request->input('description'),
            provider: $request->input('provider')
        );
    }
}
