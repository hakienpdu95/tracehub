@extends('layouts.backend')
@section('title', 'Từ điển giấy tờ pháp lý')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-base-content">Từ điển giấy tờ pháp lý</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Thêm loại giấy tờ mới không cần sửa code — chỉ cần seed vào bảng này</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('backend.products.index') }}" class="btn btn-ghost btn-sm">Quay lại danh mục</a>
        @can('create', \Modules\Product\Models\DocumentMasterType::class)
        <a href="{{ route('backend.document-master-types.create') }}" class="btn btn-primary btn-sm gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm loại giấy tờ
        </a>
        @endcan
    </div>
</div>

@if(session('success'))
<div class="alert alert-success py-2.5 px-4 mb-5 text-sm">{{ session('success') }}</div>
@endif

<div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="overflow-x-auto">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tên loại giấy tờ</th>
                    <th>Ngành hàng áp dụng</th>
                    <th>Ngày cấp</th>
                    <th>Ngày hết hạn</th>
                    <th>Hiệu lực mặc định</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($documentMasterTypes as $type)
                <tr>
                    <td class="font-mono text-xs">{{ $type->code }}</td>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->applicable_category->label() }}</td>
                    <td>{{ $type->is_required_issue_date ? 'Bắt buộc' : 'Không bắt buộc' }}</td>
                    <td>{{ $type->is_required_expiry_date ? 'Bắt buộc' : 'Không bắt buộc' }}</td>
                    <td>{{ $type->default_validity_months ? $type->default_validity_months . ' tháng' : '—' }}</td>
                    <td class="text-right space-x-1">
                        @can('update', $type)
                        <a href="{{ route('backend.document-master-types.edit', $type) }}" class="btn btn-ghost btn-xs">Sửa</a>
                        @endcan
                        @can('delete', $type)
                        <form method="POST" action="{{ route('backend.document-master-types.destroy', $type) }}"
                              class="inline" onsubmit="return confirm('Xóa loại giấy tờ này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-ghost btn-xs text-error">Xóa</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-sm text-base-content/50 py-6">Chưa có loại giấy tờ nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($documentMasterTypes->hasPages())
    <div class="card-body py-3 px-4 border-t border-base-200">
        {{ $documentMasterTypes->links() }}
    </div>
    @endif
</div>
@endsection
