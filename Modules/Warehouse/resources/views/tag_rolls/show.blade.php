@extends('layouts.backend')
@section('title', 'Cuộn tem ' . ($roll->prefix ?: $roll->id))

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content font-mono">{{ $roll->prefix ?: '(không prefix)' }} · {{ $roll->from_sequence }}–{{ $roll->to_sequence }}</h1>
        <p class="text-sm text-base-content/50 mt-0.5">In lúc {{ $roll->created_at?->format('d/m/Y H:i') }} bởi {{ $roll->creator?->name ?? 'Hệ thống (CLI)' }}</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('backend.tag-rolls.index') }}" class="btn btn-ghost btn-sm">Quay lại danh sách</a>
        <a href="{{ route('backend.tag-rolls.download-pdf', ['prefix' => $roll->prefix, 'from' => $roll->from_sequence, 'to' => $roll->to_sequence]) }}" class="btn btn-primary btn-sm">Tải PDF để in</a>
        <a href="{{ route('backend.tag-rolls.download-csv', ['prefix' => $roll->prefix, 'from' => $roll->from_sequence, 'to' => $roll->to_sequence]) }}" class="btn btn-ghost btn-sm">Tải CSV</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body py-4">
            <p class="text-xs text-base-content/50">Tổng số tem trong cuộn</p>
            <p class="text-2xl font-bold">{{ number_format($roll->count) }}</p>
        </div>
    </div>
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body py-4">
            <p class="text-xs text-base-content/50">Chưa gắn kết (còn dùng được)</p>
            <p class="text-2xl font-bold">{{ number_format($counts['provisioned']) }}</p>
        </div>
    </div>
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body py-4">
            <p class="text-xs text-base-content/50">Đã gắn kết / kích hoạt</p>
            <p class="text-2xl font-bold">{{ number_format($counts['bound']) }}</p>
        </div>
    </div>
</div>

<div class="alert alert-info py-3 px-4 text-sm">
    Để gán một dải tem trong cuộn này cho lô hàng, vào trang <strong>chi tiết Lô hàng</strong> cần dán tem và dùng card "Kích hoạt Tem Truy vết cho Lô hàng" — cuộn này sẽ xuất hiện trong danh sách chọn nếu còn tem chưa gắn kết.
</div>
@endsection
