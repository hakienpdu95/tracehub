@extends('layouts.backend')
@section('title', 'Tem truy vết — ' . $batch->internal_batch_code)

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content font-mono">{{ $batch->internal_batch_code }}</h1>
        <p class="text-sm text-base-content/50 mt-0.5">{{ $batch->product->name }} · {{ $tags->total() }} tem truy vết</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('backend.batches.show', $batch) }}" class="btn btn-ghost btn-sm">Quay lại lô hàng</a>
        <a href="{{ route('backend.batches.tags.print', $batch) }}" class="btn btn-primary btn-sm">In tem QR (PDF)</a>
    </div>
</div>

<div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="overflow-x-auto">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Số Serial</th>
                    <th>Mã QR</th>
                    <th>Trạng thái</th>
                    <th>Ngày bán</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($tags as $tag)
                <tr>
                    <td class="font-mono">{{ $tag->gs1_serial ?? $tag->serial_number }}</td>
                    <td class="font-mono">{{ $tag->qr_code }}</td>
                    <td><span class="badge {{ $tag->status->badgeClass() }} badge-xs">{{ $tag->status->label() }}</span></td>
                    <td>{{ $tag->sold_at?->format('d/m/Y H:i') ?? '—' }}</td>
                    <td class="text-right space-x-1">
                        @can('update', $batch)
                        @if(in_array($tag->status->value, ['bound', 'in_stock']))
                        <form method="POST" action="{{ route('backend.tags.unbind', $tag) }}" class="inline" onsubmit="return confirm('Gỡ gắn kết tem này? Tem sẽ quay về kho tiền định danh, có thể gán cho lô khác.');">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-xs">Gỡ gắn kết</button>
                        </form>
                        <form method="POST" action="{{ route('backend.tags.void', $tag) }}" class="inline" onsubmit="return confirm('Báo hỏng tem này? Tem sẽ bị loại khỏi vòng đời luân chuyển, không thể hoàn tác.');">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-xs text-error">Báo hỏng</button>
                        </form>
                        @endif
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-sm text-base-content/50 py-6">Chưa có tem nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tags->hasPages())
    <div class="card-body py-3 px-4 border-t border-base-200">
        {{ $tags->links() }}
    </div>
    @endif
</div>
@endsection
