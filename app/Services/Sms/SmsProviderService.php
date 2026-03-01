<?php

namespace App\Services\Sms;

use App\Models\Project;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class SmsProviderService
{
    public function forProject(Project $project): SmsProviderServiceInterface
    {
        $providers = config('sms.providers', []);
        $provider = Arr::get($providers, $project->provider);

        if (! $provider || empty($provider['class'])) {
            throw new InvalidArgumentException('Provider is not configured.');
        }

        $class = $provider['class'];

        return app($class);
    }
}
