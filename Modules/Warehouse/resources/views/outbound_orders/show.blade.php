@extends('layouts.backend')
@section('title', $order->order_number)

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content flex items-center gap-2 font-mono">
            {{ $order->order_number }}
            <span class="badge {{ $order->status->badgeClass() }} badge-sm">{{ $order->status->label() }}</span>
        </h1>
        <p class="text-sm text-base-content/50 mt-0.5">
            {{ $order->dealer_name }} · Lập ngày {{ $order->ordered_at->format('d/m/Y') }} · Tổng SL: {{ $order->totalQuantity() }}
        </p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('backend.outbound-orders.index') }}" class="btn btn-ghost btn-sm">Danh sách</a>
        @can('update', $order)
        @if($order->status->value !== 'cancelled' && $order->pickedBatches->isNotEmpty())
        <form method="POST" action="{{ route('backend.outbound-orders.activate-tags', $order) }}" onsubmit="return confirm('Kích hoạt lưu hành toàn bộ tem thuộc đơn hàng này? Từ giờ khách hàng của đại lý quét mã sẽ thấy đầy đủ thông tin sản phẩm.');">
            @csrf
            <button type="submit" class="btn btn-warning btn-sm">Kích hoạt lưu hành đơn hàng</button>
        </form>
        @endif
        @if($order->status->value === 'draft')
        <form method="POST" action="{{ route('backend.outbound-orders.complete', $order) }}" onsubmit="return confirm('Xuất kho đơn này? Tồn kho các lô và trạng thái tem QR sẽ được cập nhật, không thể hoàn tác.');">
            @csrf
            <button type="submit" class="btn btn-success btn-sm" @disabled($order->pickedBatches->isEmpty())
                @if($order->pickedBatches->isEmpty()) title="Chưa có lô nào được chọn — thêm ít nhất 1 lô ở khung gợi ý FEFO bên dưới trước." @endif
            >Xuất kho</button>
        </form>
        <form method="POST" action="{{ route('backend.outbound-orders.cancel', $order) }}" onsubmit="return confirm('Hủy đơn xuất buôn này?');">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm text-error">Hủy đơn</button>
        </form>
        @endif
        @endcan
    </div>
</div>

@if(session('success'))
<div class="alert alert-success py-2.5 px-4 mb-5 text-sm">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-error py-3 px-4 mb-5 text-sm">
    <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-[1fr_420px] gap-6 items-start">

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body">
            <h2 class="text-base font-semibold mb-4">Các lô đã chọn</h2>

            @if($order->pickedBatches->isEmpty())
            <p class="text-sm text-base-content/50">Chưa chọn lô hàng nào — dùng gợi ý FEFO bên phải để thêm.</p>
            @else
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Mã lô</th>
                            <th>Hạn dùng</th>
                            <th>Số lượng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->pickedBatches as $line)
                        <tr>
                            <td>{{ $line->product->name }}</td>
                            <td class="font-mono">
                                <a href="{{ route('backend.batches.show', $line->batch) }}" class="link link-hover">{{ $line->batch->internal_batch_code }}</a>
                            </td>
                            <td>{{ $line->batch->exp_date->format('d/m/Y') }}</td>
                            <td>{{ $line->quantity }}</td>
                            <td class="text-right">
                                @can('update', $order)
                                @if($order->status->value === 'draft')
                                <form method="POST" action="{{ route('backend.outbound-orders.batches.destroy', [$order, $line]) }}" onsubmit="return confirm('Bỏ lô này khỏi đơn?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-xs text-error">Bỏ</button>
                                </form>
                                @endif
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <div class="space-y-6">

        @if($order->notes)
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body">
                <h2 class="text-base font-semibold mb-2">Ghi chú</h2>
                <p class="text-sm whitespace-pre-line">{{ $order->notes }}</p>
            </div>
        </div>
        @endif

        @can('update', $order)
        @if($order->status->value === 'draft')
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body">
                <h2 class="text-base font-semibold mb-3">Gợi ý FEFO — chọn lô để xuất</h2>

                <form method="GET" action="{{ route('backend.outbound-orders.show', $order) }}" class="space-y-3 mb-4">
                    <div class="form-control">
                        <label class="label py-0 pb-1"><span class="label-text text-xs font-medium">Sản phẩm</span></label>
                        <select name="product_id" class="select select-bordered select-sm w-full">
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected($selectedProductId === $product->id)>{{ $product->sku }} — {{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label py-0 pb-1"><span class="label-text text-xs font-medium">Số lượng cần xuất</span></label>
                        <input type="number" name="requested_qty" value="{{ request('requested_qty', 0) }}" min="0" class="input input-bordered input-sm w-full">
                    </div>
                    <button type="submit" class="btn btn-outline btn-sm w-full">Xem gợi ý lô (FEFO)</button>
                </form>

                @if($fefoSuggestions !== null)
                @if($fefoSuggestions->isEmpty())
                <p class="text-xs text-base-content/50">Sản phẩm này chưa có lô nào còn hàng trong kho — cần tạo <a href="{{ route('backend.inbound-receipts.create') }}" class="link">phiếu nhập kho</a> và hoàn tất sinh tem QR trước khi có thể xuất buôn.</p>
                @else
                <div class="space-y-2">
                    @foreach($fefoSuggestions as $row)
                    <form method="POST" action="{{ route('backend.outbound-orders.batches.store', $order) }}" class="flex items-center gap-2 border border-base-200 rounded-lg p-2">
                        @csrf
                        <input type="hidden" name="batch_id" value="{{ $row['batch']->id }}">
                        <div class="flex-1 text-xs">
                            <div class="font-mono font-medium">{{ $row['batch']->internal_batch_code }}</div>
                            <div class="text-base-content/50">HSD {{ $row['batch']->exp_date->format('d/m/Y') }} · Còn {{ $row['batch']->current_qty }}</div>
                        </div>
                        <input type="number" name="quantity" value="{{ $row['suggested'] }}" min="1" max="{{ $row['batch']->current_qty }}" class="input input-bordered input-xs w-20">
                        <button type="submit" class="btn btn-primary btn-xs">Thêm</button>
                    </form>
                    @endforeach
                </div>
                @endif
                @endif
            </div>
        </div>
        @endif
        @endcan

    </div>
</div>
@endsection
