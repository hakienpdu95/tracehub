@extends('layouts.backend')
@section('title', 'Tạo đơn xuất buôn')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Tạo đơn xuất buôn</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Sau khi tạo, bạn sẽ chọn lô hàng theo gợi ý FEFO ở trang chi tiết</p>
    </div>
    <a href="{{ route('backend.outbound-orders.index') }}" class="btn btn-ghost btn-sm gap-1.5">
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

<form method="POST" action="{{ route('backend.outbound-orders.store') }}" novalidate>
    @csrf

    <div class="card bg-base-100 shadow-sm border border-base-200 max-w-2xl">
        <div class="card-body space-y-4">

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Mã đơn xuất buôn <span class="text-error">*</span></span></label>
                    <input type="text" name="order_number" value="{{ old('order_number') }}"
                           class="input input-bordered input-sm w-full font-mono uppercase @error('order_number') input-error @enderror">
                    @error('order_number')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Ngày lập đơn <span class="text-error">*</span></span></label>
                    <input type="date" name="ordered_at" value="{{ old('ordered_at', now()->format('Y-m-d')) }}"
                           class="input input-bordered input-sm w-full @error('ordered_at') input-error @enderror">
                    @error('ordered_at')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-control">
                <label class="label py-0 pb-1.5"><span class="label-text font-medium">Tên đại lý <span class="text-error">*</span></span></label>
                <input type="text" name="dealer_name" value="{{ old('dealer_name') }}"
                       class="input input-bordered input-sm w-full @error('dealer_name') input-error @enderror">
                @error('dealer_name')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Điện thoại đại lý</span></label>
                    <input type="text" name="dealer_phone" value="{{ old('dealer_phone') }}"
                           class="input input-bordered input-sm w-full @error('dealer_phone') input-error @enderror">
                    @error('dealer_phone')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Địa chỉ đại lý</span></label>
                    <input type="text" name="dealer_address" value="{{ old('dealer_address') }}"
                           class="input input-bordered input-sm w-full @error('dealer_address') input-error @enderror">
                    @error('dealer_address')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-control">
                <label class="label py-0 pb-1.5"><span class="label-text font-medium">Ghi chú</span></label>
                <textarea name="notes" rows="2" class="textarea textarea-bordered textarea-sm w-full @error('notes') textarea-error @enderror">{{ old('notes') }}</textarea>
                @error('notes')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
            </div>

        </div>
        <div class="card-body pt-0 flex-row justify-end gap-2 border-t border-base-200">
            <a href="{{ route('backend.outbound-orders.index') }}" class="btn btn-ghost btn-sm">Hủy</a>
            <button type="submit" class="btn btn-primary btn-sm">Tạo đơn</button>
        </div>
    </div>
</form>
@endsection
