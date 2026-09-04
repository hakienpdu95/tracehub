@extends('layouts.backend')
@section('title', 'Chỉnh sửa nhà cung cấp')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Chỉnh sửa nhà cung cấp</h1>
        <p class="text-sm text-base-content/50 mt-0.5">{{ $vendor->name }}</p>
    </div>
    <a href="{{ route('backend.vendors.show', $vendor) }}" class="btn btn-ghost btn-sm gap-1.5">
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

<form method="POST" action="{{ route('backend.vendors.update', $vendor) }}" novalidate>
    @csrf
    @method('PUT')

    <div class="card bg-base-100 shadow-sm border border-base-200 max-w-2xl">
        <div class="card-body space-y-4">

            <div class="form-control">
                <label class="label py-0 pb-1.5"><span class="label-text font-medium">Tên nhà cung cấp <span class="text-error">*</span></span></label>
                <input type="text" name="name" value="{{ old('name', $vendor->name) }}"
                       class="input input-bordered input-sm w-full @error('name') input-error @enderror">
                @error('name')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Mã nhà cung cấp</span></label>
                    <input type="text" name="vendor_code" value="{{ old('vendor_code', $vendor->vendor_code) }}"
                           class="input input-bordered input-sm w-full font-mono uppercase @error('vendor_code') input-error @enderror">
                    @error('vendor_code')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Mã số thuế <span class="text-error">*</span></span></label>
                    <input type="text" name="tax_code" value="{{ old('tax_code', $vendor->tax_code) }}"
                           class="input input-bordered input-sm w-full font-mono @error('tax_code') input-error @enderror">
                    @error('tax_code')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-control">
                <label class="label py-0 pb-1.5"><span class="label-text font-medium">Địa chỉ</span></label>
                <input type="text" name="address" value="{{ old('address', $vendor->address) }}"
                       class="input input-bordered input-sm w-full @error('address') input-error @enderror">
                @error('address')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Điện thoại</span></label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $vendor->phone_number) }}"
                           class="input input-bordered input-sm w-full @error('phone_number') input-error @enderror">
                    @error('phone_number')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Email</span></label>
                    <input type="email" name="email" value="{{ old('email', $vendor->email) }}"
                           class="input input-bordered input-sm w-full @error('email') input-error @enderror">
                    @error('email')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-control">
                <label class="label py-0 pb-1.5"><span class="label-text font-medium">Người đại diện theo pháp luật</span></label>
                <input type="text" name="representative_name" value="{{ old('representative_name', $vendor->representative_name) }}"
                       class="input input-bordered input-sm w-full @error('representative_name') input-error @enderror">
                @error('representative_name')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-control">
                <label class="label py-0 pb-1.5"><span class="label-text font-medium">Trạng thái</span></label>
                <select name="status" class="select select-bordered select-sm w-full @error('status') select-error @enderror">
                    @foreach(\Modules\Vendor\Enums\VendorStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(old('status', $vendor->status->value) === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
                @error('status')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
            </div>

        </div>
        <div class="card-body pt-0 flex-row justify-end gap-2 border-t border-base-200">
            <a href="{{ route('backend.vendors.show', $vendor) }}" class="btn btn-ghost btn-sm">Hủy</a>
            <button type="submit" class="btn btn-primary btn-sm">Lưu thay đổi</button>
        </div>
    </div>
</form>
@endsection
