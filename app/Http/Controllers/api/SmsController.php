<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Sms\SendSmsDTO;
use App\DTOs\Sms\SmsHistoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendSmsRequest;
use App\Http\Requests\SmsHistoryRequest;
use App\Http\Resources\SmsMessageResource;
use App\Services\Project\ProjectService;
use App\Services\Sms\SmsService;
use Illuminate\Http\JsonResponse;

class SmsController extends Controller
{
    public function __construct(
        private readonly SmsService $smsService,
        private readonly ProjectService $projectService,
    ) {}

    public function send(SendSmsRequest $request): JsonResponse
    {
        $project = $this->projectService
            ->findByApiKey($request->input('api_key'));

        if (! $project) {
            return response()->json(['message' => 'Invalid api_key.'], 401);
        }

        $dto = SendSmsDTO::fromRequest($request);

        $messages = $this->smsService->send($project, $dto);

        return response()->json([
            'queued' => $messages->count(),
            'message_ids' => $messages->pluck('id'),
        ], 202);
    }

    public function history(SmsHistoryRequest $request)
    {
        $project = $this->projectService
            ->findByApiKey($request->input('api_key'));

        if (! $project) {
            return response()->json(['message' => 'Invalid api_key.'], 401);
        }

        $dto = SmsHistoryDTO::fromRequest($request);

        $paginator = $this->smsService->history($project, $dto);

        return SmsMessageResource::collection($paginator);
    }
}
