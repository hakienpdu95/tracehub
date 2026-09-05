<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Product\Actions\Backend\DestroyBrandAction;
use Modules\Product\Actions\Backend\StoreBrandAction;
use Modules\Product\Data\Requests\StoreBrandData;
use Modules\Product\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', \Modules\Product\Models\Product::class);

        $brands = Brand::withCount('products')->orderBy('name')->paginate(25);

        return view('product::brands.index', compact('brands'));
    }

    public function store(Request $request, StoreBrandAction $action): RedirectResponse
    {
        $this->authorize('create', \Modules\Product\Models\Product::class);

        $data  = StoreBrandData::validateAndCreate($request->all());
        $brand = $action->handle($data);

        return redirect()->route('backend.brands.index')
            ->with('success', 'Đã thêm thương hiệu "' . $brand->name . '".');
    }

    public function destroy(Brand $brand, DestroyBrandAction $action): RedirectResponse
    {
        $this->authorize('delete', \Modules\Product\Models\Product::class);

        $action->handle($brand);

        return redirect()->route('backend.brands.index')
            ->with('success', 'Đã xóa thương hiệu.');
    }
}
