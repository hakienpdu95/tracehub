@extends('layouts.backend')
@section('title', 'Chỉnh sửa phiếu nhập kho')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Chỉnh sửa phiếu nhập kho</h1>
        <p class="text-sm text-base-content/50 mt-0.5 font-mono">{{ $inboundReceipt->receipt_number }}</p>
    </div>
    <a href="{{ route('backend.inbound-receipts.show', $inboundReceipt) }}" class="btn btn-ghost btn-sm gap-1.5">
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

<form method="POST" action="{{ route('backend.inbound-receipts.update', $inboundReceipt) }}" novalidate>
    @csrf
    @method('PUT')

    <div class="card bg-base-100 shadow-sm border border-base-200 max-w-2xl">
        <div class="card-body space-y-4">

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Mã phiếu nhập <span class="text-error">*</span></span></label>
                    <input type="text" name="receipt_number" value="{{ old('receipt_number', $inboundReceipt->receipt_number) }}"
                           class="input input-bordered input-sm w-full font-mono uppercase @error('receipt_number') input-error @enderror">
                    @error('receipt_number')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-control">
                    <label class="label py-0 pb-1.5"><span class="label-text font-medium">Ngày nhận hàng <span class="text-error">*</span></span></label>
                    <input type="date" name="received_date" value="{{ old('received_date', $inboundReceipt->received_date->format('Y-m-d')) }}"
                           class="input input-bordered input-sm w-full @error('received_date') input-error @enderror">
                    @error('received_date')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-control">
                <label class="label py-0 pb-1.5"><span class="label-text font-medium">Nhà cung cấp <span class="text-error">*</span></span></label>
                <select name="vendor_id" class="select select-bordered select-sm w-full @error('vendor_id') select-error @enderror">
                    @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}" @selected(old('vendor_id', $inboundReceipt->vendor_id) === $vendor->id)>{{ $vendor->name }}</option>
                    @endforeach
                </select>
                @error('vendor_id')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-control">
                <label class="label py-0 pb-1.5"><span class="label-text font-medium">Trạng thái</span></label>
                @if($inboundReceipt->status->value === 'completed')
                <input type="text" value="{{ $inboundReceipt->status->label() }}" class="input input-bordered input-sm w-full" disabled>
                <input type="hidden" name="status" value="completed">
                <p class="mt-1 text-xs text-base-content/50">Phiếu đã hoàn tất và sinh tem QR — không thể đổi trạng thái ở đây.</p>
                @else
                <select name="status" class="select select-bordered select-sm w-full @error('status') select-error @enderror">
                    @foreach(\Modules\Warehouse\Enums\InboundReceiptStatus::cases() as $status)
                    @continue($status->value === 'completed')
                    <option value="{{ $status->value }}" @selected(old('status', $inboundReceipt->status->value) === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-base-content/50">Để chuyển sang "Đã hoàn tất" và tự động sinh tem QR, dùng nút "Hoàn tất & Sinh tem QR" ở trang chi tiết.</p>
                @endif
                @error('status')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-control">
                <label class="label py-0 pb-1.5"><span class="label-text font-medium">Ghi chú</span></label>
                <textarea name="notes" rows="3" class="textarea textarea-bordered textarea-sm w-full @error('notes') textarea-error @enderror">{{ old('notes', $inboundReceipt->notes) }}</textarea>
                @error('notes')<p class="mt-1 text-xs text-error">{{ $message }}</p>@enderror
            </div>

        </div>
        <div class="card-body pt-0 flex-row justify-end gap-2 border-t border-base-200">
            <a href="{{ route('backend.inbound-receipts.show', $inboundReceipt) }}" class="btn btn-ghost btn-sm">Hủy</a>
            <button type="submit" class="btn btn-primary btn-sm">Lưu thay đổi</button>
        </div>
    </div>
</form>
@endsection
