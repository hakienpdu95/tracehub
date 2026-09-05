@extends('layouts.backend')
@section('title', 'Phiếu nhập kho')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Phiếu nhập kho</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Mỗi phiếu là một chuyến hàng nhận từ một nhà cung cấp</p>
    </div>
    @can('create', \Modules\Warehouse\Models\InboundReceipt::class)
    <a href="{{ route('backend.inbound-receipts.create') }}" class="btn btn-primary btn-sm gap-1.5">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tạo phiếu nhập
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
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Mã phiếu nhập..."
                       class="input input-bordered input-sm w-full">
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
                    <th>Mã phiếu</th>
                    <th>Nhà cung cấp</th>
                    <th>Ngày nhận</th>
                    <th>Số lô</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($inboundReceipts as $receipt)
                <tr>
                    <td class="font-mono">
                        <a href="{{ route('backend.inbound-receipts.show', $receipt) }}" class="link link-hover font-medium">{{ $receipt->receipt_number }}</a>
                    </td>
                    <td>{{ $receipt->vendor->name }}</td>
                    <td>{{ $receipt->received_date->format('d/m/Y') }}</td>
                    <td>{{ $receipt->batches_count }}</td>
                    <td><span class="badge {{ $receipt->status->badgeClass() }} badge-sm">{{ $receipt->status->label() }}</span></td>
                    <td class="text-right">
                        <a href="{{ route('backend.inbound-receipts.show', $receipt) }}" class="btn btn-ghost btn-xs">Xem</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-sm text-base-content/50 py-6">Chưa có phiếu nhập kho nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($inboundReceipts->hasPages())
    <div class="card-body py-3 px-4 border-t border-base-200">
        {{ $inboundReceipts->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
