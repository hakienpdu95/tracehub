<?php

namespace Modules\Warehouse\Actions\Backend;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Warehouse\Enums\RetailItemTagStatus;
use Modules\Warehouse\Models\Batch;
use Modules\Warehouse\Support\Gs1SerialGenerator;
use Modules\Warehouse\Support\TraceabilityLinkBuilder;

class GenerateRetailItemTagsAction
{
    use AsAction;

    private const CHUNK_SIZE = 500;

    public function __construct(
        private readonly TraceabilityLinkBuilder $linkBuilder,
        private readonly Gs1SerialGenerator $serialGenerator,
    ) {}

    public function handle(Batch $batch): int
    {
        if ($batch->tags()->exists()) {
            return 0;
        }

        $now          = now();
        $nextSequence = ((int) DB::table('retail_item_tags')->max('visual_sequence')) + 1;
        $prefix       = $batch->internal_batch_code;
        $serial       = 1;

        while ($serial <= $batch->initial_qty) {
            $chunkSize = min(self::CHUNK_SIZE, $batch->initial_qty - $serial + 1);
            $uids      = $this->serialGenerator->generateUids($chunkSize);
            $rows      = [];

            foreach ($uids as $uid) {
                $rows[] = [
                    'id'              => (string) Str::ulid(),
                    'organization_id' => $batch->organization_id,
                    'uid'             => $uid,
                    'gs1_serial'      => $this->serialGenerator->buildGs1Serial($prefix, $nextSequence),
                    'visual_sequence' => $nextSequence,
                    'batch_id'        => $batch->id,
                    'product_id'      => $batch->product_id,
                    'serial_number'   => $serial,
                    'qr_code'         => $this->linkBuilder->buildFromUid($uid),
                    'status'          => RetailItemTagStatus::InStock->value,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
                $serial++;
                $nextSequence++;
            }

            DB::table('retail_item_tags')->insert($rows);
        }

        return $batch->initial_qty;
    }
}
