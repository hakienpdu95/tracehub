<?php

namespace Modules\Sapo\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\Sapo\Services\SapoClient;
use Modules\Warehouse\Models\InboundReceipt;

class PushInboundReceiptToSapoJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly string $inboundReceiptId,
    ) {}

    public function handle(SapoClient $client): void
    {
        if (! config('sapo.base_url')) {
            return;
        }

        $inboundReceipt = InboundReceipt::withoutTenant()->with('batches.product')->find($this->inboundReceiptId);

        if (! $inboundReceipt) {
            return;
        }

        foreach ($inboundReceipt->batches as $batch) {
            if (! $batch->product->external_product_id) {
                continue;
            }

            $serials = $batch->tags()->pluck('qr_code')->all();

            if (empty($serials)) {
                continue;
            }

            try {
                $response = $client->post(config('sapo.receipt_push_endpoint'), [
                    'product_id' => $batch->product->external_product_id,
                    'batch_code' => $batch->internal_batch_code,
                    'quantity'   => count($serials),
                    'serials'    => $serials,
                ]);

                if ($response->failed()) {
                    Log::error('Push inbound receipt to Sapo failed', [
                        'batch_id' => $batch->id,
                        'status'   => $response->status(),
                        'body'     => $response->body(),
                    ]);
                }
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                Log::error('Push inbound receipt to Sapo: connection failed', [
                    'batch_id' => $batch->id,
                    'message'  => $e->getMessage(),
                ]);
            }
        }
    }
}
