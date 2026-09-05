@extends('layouts.backend')
@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Thêm sản phẩm mới</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Điền thông tin định danh vật lý của sản phẩm</p>
    </div>
    <a href="{{ route('backend.products.index') }}" class="btn btn-ghost btn-sm gap-1.5">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Quay lại
    </a>
</div>

@if($errors->any())
<div class="alert alert-error py-3 px-4 mb-5 flex items-start gap-3 text-sm">
    <div>
        <p class="font-semibold">Có {{ $errors->count() }} lỗi cần kiểm tra:</p>
        <ul class="mt-1.5 list-disc list-inside space-y-0.5 text-xs opacity-90">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
</div>
@endif

<form method="POST" action="{{ route('backend.products.store') }}" novalidate>
    @csrf

    <div class="card bg-base-100 shadow-sm border border-base-200 max-w-2xl">
        <div class="card-body space-y-4">

            <div class="form-control">
                <label class="label py-0 pb-1.5"><span class="label-text font-medium">Tên sản phẩm <span class="text-error">*</span></span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="input input-bordered input-sm w-full @error('name') input-error @enderror">
                @error('name')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Mã SKU <span class="text-error">*</span></span></label>
                    <input type="text" name="sku" value="{{ old('sku') }}"
                           class="input input-bordered input-sm w-full font-mono uppercase @error('sku') input-error @enderror">
                    @error('sku')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Mã vạch</span></label>
                    <input type="text" name="barcode" value="{{ old('barcode') }}"
                           class="input input-bordered input-sm w-full font-mono @error('barcode') input-error @enderror">
                    @error('barcode')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Thương hiệu</span></label>
                    <select name="brand_id" class="select select-bordered select-sm w-full @error('brand_id') select-error @enderror">
                        <option value="">— Không có —</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(old('brand_id') === $brand->id)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Đơn vị tính <span class="text-error">*</span></span></label>
                    <input type="text" name="unit" value="{{ old('unit') }}" placeholder="Hộp, Bịch, Cái..."
                           class="input input-bordered input-sm w-full @error('unit') input-error @enderror">
                    @error('unit')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Ngành hàng <span class="text-error">*</span></span></label>
                    <select name="category_type" class="select select-bordered select-sm w-full @error('category_type') select-error @enderror">
                        @foreach(\Modules\Product\Enums\ProductCategoryType::cases() as $category)
                        <option value="{{ $category->value }}" @selected(old('category_type') === $category->value)>{{ $category->label() }}</option>
                        @endforeach
                    </select>
                    @error('category_type')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Trạng thái</span></label>
                    <select name="status" class="select select-bordered select-sm w-full @error('status') select-error @enderror">
                        @foreach(\Modules\Product\Enums\ProductStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(old('status', 'active') === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>
            </div>

        </div>
        <div class="card-body pt-0 flex-row justify-end gap-2 border-t border-base-200">
            <a href="{{ route('backend.products.index') }}" class="btn btn-ghost btn-sm">Hủy</a>
            <button type="submit" class="btn btn-primary btn-sm">Lưu sản phẩm</button>
        </div>
    </div>
</form>
@endsection
