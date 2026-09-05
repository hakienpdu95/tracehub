@extends('layouts.backend')
@section('title', 'Thương hiệu')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Thương hiệu</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Từ điển thương hiệu — tránh nhập tay gây trùng lặp dữ liệu</p>
    </div>
    <a href="{{ route('backend.products.index') }}" class="btn btn-ghost btn-sm">Quay lại danh mục</a>
</div>

@if(session('success'))
<div class="alert alert-success py-2.5 px-4 mb-5 text-sm">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-6 items-start">

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Tên thương hiệu</th>
                        <th>Số sản phẩm</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                    <tr>
                        <td class="font-medium">{{ $brand->name }}</td>
                        <td>{{ $brand->products_count }}</td>
                        <td class="text-right">
                            @can('delete', \Modules\Product\Models\Product::class)
                            <form method="POST" action="{{ route('backend.brands.destroy', $brand) }}"
                                  onsubmit="return confirm('Xóa thương hiệu này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-xs text-error" @disabled($brand->products_count > 0)>Xóa</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-sm text-base-content/50 py-6">Chưa có thương hiệu nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($brands->hasPages())
        <div class="card-body py-3 px-4 border-t border-base-200">
            {{ $brands->links() }}
        </div>
        @endif
    </div>

    @can('create', \Modules\Product\Models\Product::class)
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body">
            <h2 class="text-base font-semibold mb-3">Thêm thương hiệu mới</h2>

            @if($errors->any())
            <div class="alert alert-error py-2 px-3 mb-3 text-xs">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('backend.brands.store') }}" class="flex gap-2">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Tên thương hiệu"
                       class="input input-bordered input-sm flex-1">
                <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
            </form>
        </div>
    </div>
    @endcan

</div>
@endsection
