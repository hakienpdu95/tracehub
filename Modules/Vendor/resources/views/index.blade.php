@extends('layouts.backend')
@section('title', 'Nhà cung cấp')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Nhà cung cấp</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Quản lý nhà cung cấp và hồ sơ pháp lý đi kèm</p>
    </div>
    @can('create', \Modules\Vendor\Models\Vendor::class)
    <a href="{{ route('backend.vendors.create') }}" class="btn btn-primary btn-sm gap-1.5">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Thêm nhà cung cấp
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
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên, mã NCC hoặc mã số thuế..."
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
                    <th>Mã NCC</th>
                    <th>Tên</th>
                    <th>Mã số thuế</th>
                    <th>Trạng thái</th>
                    <th>Chứng chỉ mới nhất</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                <tr>
                    <td class="font-mono">{{ $vendor->vendor_code ?? '—' }}</td>
                    <td>
                        <a href="{{ route('backend.vendors.show', $vendor) }}" class="link link-hover font-medium">{{ $vendor->name }}</a>
                    </td>
                    <td class="font-mono">{{ $vendor->tax_code }}</td>
                    <td><span class="badge {{ $vendor->status->badgeClass() }} badge-sm">{{ $vendor->status->label() }}</span></td>
                    <td>
                        @if($vendor->latestCertificate)
                        {{ $vendor->latestCertificate->certificate_type->label() }}
                        @if($vendor->latestCertificate->isExpired())
                        <span class="badge badge-error badge-xs ml-1">Hết hạn</span>
                        @elseif($vendor->latestCertificate->isExpiringWithinDays(30))
                        <span class="badge badge-warning badge-xs ml-1">Sắp hết hạn</span>
                        @endif
                        @else
                        <span class="text-xs text-base-content/40">Chưa có</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('backend.vendors.show', $vendor) }}" class="btn btn-ghost btn-xs">Xem</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-sm text-base-content/50 py-6">Chưa có nhà cung cấp nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($vendors->hasPages())
    <div class="card-body py-3 px-4 border-t border-base-200">
        {{ $vendors->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
