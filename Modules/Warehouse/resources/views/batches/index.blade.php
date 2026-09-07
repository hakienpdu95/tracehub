@extends('layouts.backend')
@section('title', 'Lô hàng')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Lô hàng</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Trung tâm điều phối truy xuất nguồn gốc: chứng từ, tem GS1, đồng bộ Sapo và audit trail của từng lô</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success py-2.5 px-4 mb-5 text-sm">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error py-2.5 px-4 mb-5 text-sm">{{ session('error') }}</div>
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

@php
$icon = function (string $path) {
    return '<svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' . $path . '"/></svg>';
};
@endphp

<div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="overflow-x-auto">
        <table class="w-full divide-y divide-gray-200">
            <thead>
                <tr class="text-left">
                    <th class="px-4 py-3 text-xs font-semibold text-base-content/50 uppercase tracking-wide">Lô & Sản phẩm</th>
                    <th class="px-4 py-3 text-xs font-semibold text-base-content/50 uppercase tracking-wide">Hồ sơ & Chứng từ</th>
                    <th class="px-4 py-3 text-xs font-semibold text-base-content/50 uppercase tracking-wide">Tem & Tồn kho</th>
                    <th class="px-4 py-3 text-xs font-semibold text-base-content/50 uppercase tracking-wide text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($batches as $batch)
                @php
                    $product = $batch->product;
                    $latestCompliance = $product?->latestCompliance;
                    $hasIncidents = $batch->adverse_event_reports_count > 0;
                @endphp
                <tr>
                    {{-- Cột 1: Thông tin Lô & Sản phẩm --}}
                    <td class="align-top px-4 py-4">
                        <div class="flex flex-row gap-3">
                            <div class="avatar placeholder shrink-0">
                                <div class="bg-neutral text-neutral-content rounded-lg w-12 h-12">
                                    <span class="text-lg">{{ $product ? mb_strtoupper(mb_substr($product->name, 0, 1)) : '?' }}</span>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold truncate">{{ $product?->name ?? '—' }}</p>
                                <p class="text-xs text-base-content/50 font-mono">{{ $product?->sku ?? '—' }}</p>

                                <a href="{{ route('backend.batches.show', $batch) }}" class="block mt-1.5 font-mono text-base font-bold text-primary link link-hover">
                                    {{ $batch->internal_batch_code }}
                                </a>

                                <p class="text-xs text-base-content/60 mt-1">
                                    <span class="text-base-content/40">Nhà cung cấp:</span> {{ $batch->vendor?->name ?? '—' }}
                                </p>
                                <p class="text-xs text-base-content/60">
                                    <span class="text-base-content/40">NSX:</span> {{ $batch->mfg_date?->format('d/m/Y') ?? '—' }}
                                    <span class="text-base-content/40 ml-1">HSD:</span> {{ $batch->exp_date->format('d/m/Y') }}
                                    @if($batch->isExpired())
                                    <span class="badge badge-error badge-xs ml-1">Hết hạn</span>
                                    @elseif($batch->isExpiringWithinDays(30))
                                    <span class="badge badge-warning badge-xs ml-1">Sắp hết hạn</span>
                                    @endif
                                </p>

                                <span class="badge {{ $batch->status->badgeClass() }} badge-sm mt-2">{{ $batch->status->label() }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- Cột 2: Hồ sơ & Chứng từ --}}
                    <td class="align-top px-4 py-4">
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('backend.inbound-receipts.show', $batch->inboundReceipt) }}" class="flex items-center gap-1.5 text-xs link link-hover">
                                {!! $icon('M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z') !!}
                                Xem phiếu nhập kho gốc
                            </a>

                            @if($latestCompliance)
                            <a href="{{ $latestCompliance->file_url ?: '#' }}" @if($latestCompliance->file_url) target="_blank" rel="noopener" @endif
                               class="flex items-center gap-1.5 text-xs text-blue-600 hover:underline font-medium">
                                {!! $icon('M9 17v-2a4 4 0 014-4h4M9 17H7a2 2 0 01-2-2V7a2 2 0 012-2h6l4 4v6a2 2 0 01-2 2h-2m-4 0h4') !!}
                                Bản công bố / COA ({{ $latestCompliance->document_number }})
                            </a>
                            @else
                            <p class="flex items-center gap-1.5 text-xs text-base-content/40">
                                {!! $icon('M9 17v-2a4 4 0 014-4h4M9 17H7a2 2 0 01-2-2V7a2 2 0 012-2h6l4 4v6a2 2 0 01-2 2h-2m-4 0h4') !!}
                                Chưa có bản công bố / COA
                            </p>
                            @endif

                            @if($hasIncidents)
                            <a href="{{ route('backend.batches.incidents', $batch) }}" class="flex items-center gap-1.5 text-xs link link-hover text-error font-medium">
                                {!! $icon('M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z') !!}
                                Báo cáo sự cố 18-MP ({{ $batch->adverse_event_reports_count }})
                            </a>
                            @else
                            <p class="flex items-center gap-1.5 text-xs text-base-content/40">
                                {!! $icon('M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z') !!}
                                Không có khiếu nại
                            </p>
                            @endif
                        </div>
                    </td>

                    {{-- Cột 3: Tem & Tồn kho --}}
                    <td class="align-top px-4 py-4">
                        <p class="text-xs mb-2">
                            Tồn thực tế: <span class="font-semibold">{{ $batch->current_qty }}</span> |
                            Đã gán: <span class="font-semibold">{{ $batch->tags_count }}</span> |
                            Sapo: <span class="font-semibold">{{ $batch->tags_exported_count }}</span>
                        </p>

                        <div class="flex flex-col gap-2">
                            <a href="{{ route('backend.batches.show', $batch) }}" class="flex items-center gap-1.5 text-xs link link-hover">
                                {!! $icon('M7 7h.01M7 3h5.586a1 1 0 01.707.293l6.414 6.414a1 1 0 010 1.414l-6.586 6.586a1 1 0 01-1.414 0L5.293 11.293A1 1 0 015 10.586V5a2 2 0 012-2z') !!}
                                Gán dải tem / Quản lý tem
                            </a>

                            <a href="{{ route('backend.batches.sapo-sync-log', $batch) }}" class="flex items-center gap-1.5 text-xs link link-hover">
                                {!! $icon('M16 15v4.5M16 15l3 3M16 15l-3 3M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15') !!}
                                Nhật ký đồng bộ Sapo POS
                            </a>
                        </div>
                    </td>

                    {{-- Cột 4: Thao tác --}}
                    <td class="align-top px-4 py-4 text-right">
                        <div class="flex flex-col items-end gap-2">
                            <a href="{{ route('backend.batches.show', $batch) }}" class="btn btn-primary btn-xs">Xem chi tiết lô</a>

                            <a href="{{ route('backend.batches.audit-trail', $batch) }}" class="btn btn-ghost btn-xs">Lịch sử thao tác</a>

                            @can('recall', $batch)
                            @if($batch->status->value !== 'recalled')
                            <form method="POST" action="{{ route('backend.batches.recall', $batch) }}"
                                  onsubmit="return confirm('Đánh dấu lô \'{{ $batch->internal_batch_code }}\' là thu hồi? Hành động này sẽ khóa toàn bộ hàng của lô trên kệ.');">
                                @csrf
                                <button type="submit" class="btn btn-xs bg-red-600 hover:bg-red-700 border-red-600 text-white">Thu hồi lô</button>
                            </form>
                            @endif
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-sm text-base-content/50 py-10">Chưa có lô hàng nào.</td>
                </tr>
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
