@extends('layouts.backend')
@section('title', 'Cảnh báo pháp lý & hạn dùng')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Cảnh báo pháp lý & hạn dùng</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Hộp thư tập trung — hồ sơ sản phẩm, chứng chỉ nhà cung cấp, lô hàng cận date</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success py-2.5 px-4 mb-5 text-sm">{{ session('success') }}</div>
@endif

<div class="card bg-base-100 shadow-sm border border-base-200 mb-4">
    <div class="card-body py-3 px-4">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="form-control">
                <label class="label py-0 pb-1"><span class="label-text text-xs">Trạng thái</span></label>
                <select name="status" class="select select-bordered select-sm">
                    <option value="">Đang mở (mặc định)</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status['value'] }}" @selected(request('status') === $status['value'])>{{ $status['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label py-0 pb-1"><span class="label-text text-xs">Loại cảnh báo</span></label>
                <select name="category" class="select select-bordered select-sm">
                    <option value="">Tất cả</option>
                    @foreach($categories as $category)
                    <option value="{{ $category['value'] }}" @selected(request('category') === $category['value'])>{{ $category['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label py-0 pb-1"><span class="label-text text-xs">Mức độ</span></label>
                <select name="severity" class="select select-bordered select-sm">
                    <option value="">Tất cả</option>
                    @foreach($severities as $severity)
                    <option value="{{ $severity['value'] }}" @selected(request('severity') === $severity['value'])>{{ $severity['label'] }}</option>
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
                    <th>Mức độ</th>
                    <th>Loại</th>
                    <th>Nội dung</th>
                    <th>Hạn</th>
                    <th>Còn lại</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($warnings as $warning)
                <tr>
                    <td><span class="badge {{ $warning->severity->badgeClass() }} badge-sm">{{ $warning->severity->label() }}</span></td>
                    <td class="text-xs">{{ $warning->category->label() }}</td>
                    <td>
                        <div class="font-medium text-sm">{{ $warning->title }}</div>
                        <div class="text-xs text-base-content/50">{{ $warning->message }}</div>
                    </td>
                    <td>{{ $warning->due_date->format('d/m/Y') }}</td>
                    <td>
                        @php($days = $warning->daysRemaining())
                        @if($days < 0)
                        <span class="text-error font-medium">Quá hạn {{ abs($days) }} ngày</span>
                        @else
                        {{ $days }} ngày
                        @endif
                    </td>
                    <td><span class="badge {{ $warning->status->badgeClass() }} badge-sm">{{ $warning->status->label() }}</span></td>
                    <td class="text-right space-x-1">
                        @can('update', $warning)
                        @if($warning->status->value === 'pending')
                        <form method="POST" action="{{ route('backend.compliance-warnings.acknowledge', $warning) }}" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-xs">Ghi nhận</button>
                        </form>
                        @endif
                        @if($warning->status->value !== 'resolved')
                        <form method="POST" action="{{ route('backend.compliance-warnings.resolve', $warning) }}" class="inline" onsubmit="return confirm('Đánh dấu cảnh báo này đã xử lý xong?');">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-xs text-success">Xử lý xong</button>
                        </form>
                        @endif
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-sm text-base-content/50 py-6">Không có cảnh báo nào đang mở.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($warnings->hasPages())
    <div class="card-body py-3 px-4 border-t border-base-200">
        {{ $warnings->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
