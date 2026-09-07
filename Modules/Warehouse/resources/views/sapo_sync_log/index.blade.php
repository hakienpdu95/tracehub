@extends('layouts.backend')
@section('title', 'Đồng bộ Sapo POS')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-base-content">Đồng bộ Sapo POS</h1>
    <p class="text-sm text-base-content/50 mt-0.5">Nhật ký các tem đã được trừ kho tự động qua đơn hàng bán lẻ Sapo — dùng để đối soát tồn kho.</p>
</div>

<div class="card bg-base-100 shadow-sm border border-base-200 mb-4">
    <div class="card-body py-3 px-4">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="form-control flex-1 min-w-[220px]">
                <label class="label py-0 pb-1"><span class="label-text text-xs">Tìm kiếm</span></label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Mã QR, GS1 serial hoặc mã đơn Sapo..."
                       class="input input-bordered input-sm w-full">
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
                    <th>Thời điểm trừ kho</th>
                    <th>Serial tem</th>
                    <th>Sản phẩm</th>
                    <th>Lô hàng</th>
                    <th>Mã đơn Sapo</th>
                    <th>Trạng thái đơn</th>
                    <th>Trạng thái tem</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entries as $tag)
                <tr>
                    <td class="whitespace-nowrap">{{ $tag->sold_at?->format('d/m/Y H:i:s') ?? '—' }}</td>
                    <td class="font-mono">{{ $tag->gs1_serial ?? $tag->serial_number }}</td>
                    <td>{{ $tag->product?->name ?? '—' }}</td>
                    <td class="font-mono">
                        @if($tag->batch)
                        <a href="{{ route('backend.batches.show', $tag->batch) }}" class="link link-hover">{{ $tag->batch->internal_batch_code }}</a>
                        @else
                        —
                        @endif
                    </td>
                    <td class="font-mono">{{ $tag->externalOrder?->external_order_code ?? '—' }}</td>
                    <td>{{ $tag->externalOrder?->status ?? '—' }}</td>
                    <td><span class="badge {{ $tag->status->badgeClass() }} badge-xs">{{ $tag->status->label() }}</span></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-sm text-base-content/50 py-6">Chưa có tem nào được xuất bán qua Sapo.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($entries->hasPages())
    <div class="card-body py-3 px-4 border-t border-base-200">
        {{ $entries->links() }}
    </div>
    @endif
</div>
@endsection
