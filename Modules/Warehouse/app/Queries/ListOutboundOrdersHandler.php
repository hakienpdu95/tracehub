<?php

namespace Modules\Warehouse\Queries;

use App\Shared\Contracts\QueryHandlerInterface;
use App\Shared\Contracts\QueryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Warehouse\Models\OutboundOrder;

class ListOutboundOrdersHandler implements QueryHandlerInterface
{
    public function handle(QueryInterface $query): LengthAwarePaginator
    {
        /** @var ListOutboundOrdersQuery $query */
        $q = OutboundOrder::query()->withCount('pickedBatches')->latest('ordered_at');

        if ($query->status !== null && $query->status !== '') {
            $q->where('status', $query->status);
        }

        return $q->paginate($query->perPage, ['*'], 'page', $query->page);
    }
}
