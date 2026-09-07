<?php

namespace Modules\Warehouse\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Warehouse\Models\RetailItemTag;

class SapoSyncLogController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(auth()->user()->can('warehouse.view'), 403);

        $search = trim((string) $request->input('search', ''));

        $entries = RetailItemTag::query()
            ->whereNotNull('external_order_id')
            ->with(['batch:id,internal_batch_code', 'product:id,name,sku', 'externalOrder'])
            ->when($search !== '', function ($q) use ($search) {
                $term = '%' . $search . '%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('qr_code', 'like', $term)
                        ->orWhere('gs1_serial', 'like', $term)
                        ->orWhereHas('externalOrder', fn ($eo) => $eo->where('external_order_code', 'like', $term));
                });
            })
            ->orderByDesc('sold_at')
            ->paginate(25)
            ->withQueryString();

        return view('warehouse::sapo_sync_log.index', compact('entries', 'search'));
    }
}
