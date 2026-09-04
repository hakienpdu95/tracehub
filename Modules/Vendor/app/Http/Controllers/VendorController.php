<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Vendor\Actions\Backend\DestroyVendorAction;
use Modules\Vendor\Actions\Backend\StoreVendorAction;
use Modules\Vendor\Actions\Backend\UpdateVendorAction;
use Modules\Vendor\Data\Requests\StoreVendorData;
use Modules\Vendor\Data\Requests\UpdateVendorData;
use Modules\Vendor\Enums\VendorStatus;
use Modules\Vendor\Models\Vendor;
use Modules\Vendor\Queries\GetVendorHandler;
use Modules\Vendor\Queries\GetVendorQuery;
use Modules\Vendor\Queries\ListVendorsHandler;
use Modules\Vendor\Queries\ListVendorsQuery;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Vendor::class, 'vendor');
    }

    public function index(Request $request, ListVendorsHandler $handler)
    {
        $vendors = $handler->handle(new ListVendorsQuery(
            page:      max(1, (int) $request->integer('page', 1)),
            perPage:   25,
            sortField: (string) $request->input('sort', 'created_at'),
            sortDir:   (string) $request->input('dir', 'desc'),
            search:    $request->input('search'),
            status:    $request->input('status'),
        ));

        $statuses = collect(VendorStatus::cases())
            ->map(fn ($s) => ['value' => $s->value, 'label' => $s->label()])
            ->all();

        return view('vendor::index', compact('vendors', 'statuses'));
    }

    public function create()
    {
        return view('vendor::create');
    }

    public function store(Request $request, StoreVendorAction $action): RedirectResponse
    {
        $data   = StoreVendorData::validateAndCreate($request->all());
        $vendor = $action->handle($data);

        return redirect()->route('backend.vendors.show', $vendor)
            ->with('success', 'Nhà cung cấp "' . $vendor->name . '" đã được tạo thành công.');
    }

    public function show(Vendor $vendor, GetVendorHandler $handler)
    {
        $vendor = $handler->handle(new GetVendorQuery($vendor));

        return view('vendor::show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('vendor::edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor, UpdateVendorAction $action): RedirectResponse
    {
        $data = UpdateVendorData::validateAndCreate($request->all());
        $action->handle($vendor, $data);

        return redirect()->route('backend.vendors.show', $vendor)
            ->with('success', 'Cập nhật nhà cung cấp thành công.');
    }

    public function destroy(Request $request, Vendor $vendor, DestroyVendorAction $action): RedirectResponse|JsonResponse
    {
        $name = $action->handle($vendor);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Đã xóa nhà cung cấp "' . $name . '".']);
        }

        return redirect()->route('backend.vendors.index')
            ->with('success', 'Đã xóa nhà cung cấp "' . $name . '".');
    }
}
