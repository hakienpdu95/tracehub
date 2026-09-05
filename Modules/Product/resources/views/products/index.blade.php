@extends('layouts.backend')
@section('title', 'Sản phẩm')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Danh mục sản phẩm</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Quản lý SKU và hồ sơ pháp lý đi kèm</p>
    </div>
    @can('create', \Modules\Product\Models\Product::class)
    <a href="{{ route('backend.products.create') }}" class="btn btn-primary btn-sm gap-1.5">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Thêm sản phẩm
    </a>
    @endcan
</div>

@if(session('success'))
<div class="alert alert-success py-2.5 px-4 mb-5 text-sm">{{ session('success') }}</div>
@endif

<div class="card bg-base-100 shadow-sm border border-base-200 mb-4">
    <div class="card-body py-3 px-4">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="form-control flex-1 min-w-[200px]">
                <label class="label py-0 pb-1"><span class="label-text text-xs">Tìm kiếm</span></label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên, SKU hoặc mã vạch..."
                       class="input input-bordered input-sm w-full">
            </div>
            <div class="form-control">
                <label class="label py-0 pb-1"><span class="label-text text-xs">Ngành hàng</span></label>
                <select name="category_type" class="select select-bordered select-sm">
                    <option value="">Tất cả</option>
                    @foreach($categoryTypes as $category)
                    <option value="{{ $category['value'] }}" @selected(request('category_type') === $category['value'])>{{ $category['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label py-0 pb-1"><span class="label-text text-xs">Trạng thái</span></label>
                <select name="status" class="select select-bordered select-sm">
                    <option value="">Tất cả</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status['value'] }}" @selected(request('status') === $status['value'])>{{ $status['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-sm btn-outline">Lọc</button>
        </form>
    </div>
</div>

<div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="overflow-x-auto">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Tên sản phẩm</th>
                    <th>Thương hiệu</th>
                    <th>Ngành hàng</th>
                    <th>Trạng thái</th>
                    <th>Hồ sơ pháp lý gần nhất</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="font-mono">{{ $product->sku }}</td>
                    <td>
                        <a href="{{ route('backend.products.show', $product) }}" class="link link-hover font-medium">{{ $product->name }}</a>
                    </td>
                    <td>{{ $product->brand?->name ?? '—' }}</td>
                    <td>{{ $product->category_type->label() }}</td>
                    <td><span class="badge {{ $product->status->badgeClass() }} badge-sm">{{ $product->status->label() }}</span></td>
                    <td>
                        @if($product->latestCompliance)
                        {{ $product->latestCompliance->documentType->name }}
                        @if($product->latestCompliance->isExpired())
                        <span class="badge badge-error badge-xs ml-1">Hết hạn</span>
                        @elseif($product->latestCompliance->isExpiringWithinDays(30))
                        <span class="badge badge-warning badge-xs ml-1">Sắp hết hạn</span>
                        @endif
                        @else
                        <span class="text-xs text-base-content/40">Chưa có</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('backend.products.show', $product) }}" class="btn btn-ghost btn-xs">Xem</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-sm text-base-content/50 py-6">Chưa có sản phẩm nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="card-body py-3 px-4 border-t border-base-200">
        {{ $products->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
