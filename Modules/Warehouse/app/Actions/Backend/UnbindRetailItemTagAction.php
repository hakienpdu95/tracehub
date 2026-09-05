<?php

namespace Modules\Warehouse\Actions\Backend;

use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Warehouse\Enums\RetailItemTagStatus;
use Modules\Warehouse\Models\RetailItemTag;

class UnbindRetailItemTagAction
{
    use AsAction;

    public function handle(RetailItemTag $tag): void
    {
        if ($tag->status !== RetailItemTagStatus::InStock) {
            throw ValidationException::withMessages([
                'tag' => "Không thể gỡ gắn kết tem đang ở trạng thái \"{$tag->status->label()}\". Chỉ gỡ được tem còn trên kệ.",
            ]);
        }

        $tag->update([
            'product_id'    => null,
            'batch_id'      => null,
            'serial_number' => null,
            'status'        => RetailItemTagStatus::Provisioned->value,
        ]);
    }
}
