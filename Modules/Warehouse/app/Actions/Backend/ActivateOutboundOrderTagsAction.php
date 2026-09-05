<?php

namespace Modules\Warehouse\Actions\Backend;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Warehouse\Enums\RetailItemTagStatus;
use Modules\Warehouse\Models\OutboundOrder;
use Modules\Warehouse\Models\RetailItemTag;

class ActivateOutboundOrderTagsAction
{
    use AsAction;

    /**
     * "Bật công tắc" lưu hành cho toàn bộ tem thuộc các lô trong đơn xuất buôn này —
     * chỉ áp dụng đúng bằng số lượng đã chọn (quantity) trên từng dòng lô, tránh
     * kích hoạt nhầm phần hàng còn lại của lô chưa thuộc đơn hàng này.
     *
     * Xử lý cả 2 thời điểm bấm nút: trước khi xuất kho (tem còn "bound" -> "in_stock")
     * và sau khi đã xuất kho (tem đã "transferred" -> "transferred_active").
     */
    public function handle(OutboundOrder $order): int
    {
        return DB::transaction(function () use ($order) {
            $total = 0;

            foreach ($order->pickedBatches as $line) {
                $boundIds = RetailItemTag::where('batch_id', $line->batch_id)
                    ->where('status', RetailItemTagStatus::Bound->value)
                    ->limit($line->quantity)
                    ->pluck('id');

                $total += RetailItemTag::whereIn('id', $boundIds)
                    ->update(['status' => RetailItemTagStatus::InStock->value]);

                $remaining = $line->quantity - $boundIds->count();

                if ($remaining > 0) {
                    $transferredIds = RetailItemTag::where('batch_id', $line->batch_id)
                        ->where('status', RetailItemTagStatus::Transferred->value)
                        ->limit($remaining)
                        ->pluck('id');

                    $total += RetailItemTag::whereIn('id', $transferredIds)
                        ->update(['status' => RetailItemTagStatus::TransferredActive->value]);
                }
            }

            return $total;
        });
    }
}
