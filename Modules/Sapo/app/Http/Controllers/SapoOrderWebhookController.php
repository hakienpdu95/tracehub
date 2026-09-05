<?php

namespace Modules\Sapo\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Tenancy\Models\Organization;
use App\Shared\Tenancy\TenantContext;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Sapo\Actions\ProcessSapoOrderWebhookAction;
use Modules\Sapo\Models\ExternalOrder;

class SapoOrderWebhookController extends Controller
{
    public function handle(Request $request, string $org_id, ProcessSapoOrderWebhookAction $action): JsonResponse
    {
        $secret = (string) config('sapo.webhook_secret');

        if ($secret === '' || ! hash_equals($secret, (string) $request->query('token'))) {
            abort(401, 'Invalid webhook token.');
        }

        $org = Organization::findOrFail($org_id);
        TenantContext::set($org);

        $payload = $request->all();
        $rawBody = $request->getContent();

        try {
            $order = $action->handle($payload, $rawBody);
        } catch (\Throwable $e) {
            Log::error('Sapo order webhook processing failed: ' . $e->getMessage(), ['payload' => $rawBody]);

            ExternalOrder::create([
                'external_system'     => 'sapo',
                'external_order_code' => (string) ($payload['name'] ?? $payload['id'] ?? uniqid('sapo-failed-', true)),
                'status'              => 'failed',
                'raw_payload'         => $rawBody,
            ]);

            return response()->json(['status' => 'error'], 500);
        }

        return response()->json(['status' => 'ok', 'order_id' => $order->id]);
    }
}
