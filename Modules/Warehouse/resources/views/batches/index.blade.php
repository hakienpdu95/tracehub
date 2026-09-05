@extends('layouts.backend')
@section('title', 'Lô hàng')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Lô hàng</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Tra cứu theo mã lô nhà sản xuất hoặc mã lô nội bộ (QR)</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success py-2.5 px-4 mb-5 text-sm">{{ session('success') }}</div>
@endif

<div class="card bg-base-100 shadow-sm border border-base-200 mb-4">
    <div class="card-body py-3 px-4">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="form-control flex-1 min-w-[220px]">
                <label class="label py-0 pb-1"><span class="label-text text-xs">Tìm kiếm</span></label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Mã lô NSX hoặc mã lô nội bộ..."
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
                    <th>Mã lô nội bộ</th>
                    <th>Mã lô NSX</th>
                    <th>Sản phẩm</th>
                    <th>Nhà cung cấp</th>
                    <th>Hạn dùng</th>
                    <th>Tồn kho</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($batches as $batch)
                <tr>
                    <td class="font-mono">
                        <a href="{{ route('backend.batches.show', $batch) }}" class="link link-hover">{{ $batch->internal_batch_code }}</a>
                    </td>
                    <td class="font-mono text-xs">{{ $batch->mfg_batch_number ?? '—' }}</td>
                    <td>{{ $batch->product->name }}</td>
                    <td>{{ $batch->vendor->name }}</td>
                    <td>
                        {{ $batch->exp_date->format('d/m/Y') }}
                        @if($batch->isExpired())
                        <span class="badge badge-error badge-xs ml-1">Hết hạn</span>
                        @elseif($batch->isExpiringWithinDays(30))
                        <span class="badge badge-warning badge-xs ml-1">Sắp hết hạn</span>
                        @endif
                    </td>
                    <td>{{ $batch->current_qty }} / {{ $batch->initial_qty }}</td>
                    <td><span class="badge {{ $batch->status->badgeClass() }} badge-xs">{{ $batch->status->label() }}</span></td>
                    <td class="text-right">
                        <a href="{{ route('backend.batches.show', $batch) }}" class="btn btn-ghost btn-xs">Xem</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-sm text-base-content/50 py-6">Chưa có lô hàng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($batches->hasPages())
    <div class="card-body py-3 px-4 border-t border-base-200">
        {{ $batches->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
