@extends('layouts.backend')
@section('title', 'Đồng bộ Sapo POS')

@section('content')
<div x-data="sapoSyncLogListPage({{ Js::from([
    'apiUrl' => route('backend.api.sapo-sync-log'),
]) }})">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-base-content">Đồng bộ Sapo POS</h1>
        <p class="text-sm text-base-content/50 mt-0.5">Nhật ký các tem đã được trừ kho tự động qua đơn hàng bán lẻ Sapo — dùng để đối soát tồn kho.</p>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200 mb-4">
        <div class="card-body py-3 px-4">
            <div class="form-control max-w-sm">
                <label class="label py-0.5">
                    <span class="label-text text-xs font-medium">Tìm kiếm</span>
                    <span class="label-text-alt text-xs text-base-content/40">Mã QR, GS1 serial, mã đơn Sapo</span>
                </label>
                <div class="input input-sm input-bordered flex items-center gap-2 bg-base-100">
                    <svg class="w-3.5 h-3.5 text-base-content/40 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="filter-search" type="text"
                           x-model="filters.search"
                           @input.debounce.350ms="onFilterChange()"
                           placeholder="Nhập từ khóa..."
                           class="grow bg-transparent outline-none text-sm"/>
                    <button x-show="filters.search" @click="clearSearch()"
                            class="text-base-content/30 hover:text-base-content transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-0 overflow-hidden tabulator-daisy">
            <div id="sapo-sync-log-table"></div>
        </div>
    </div>

</div>
@endsection

@push('styles')
    <x-tabulator-theme />
@endpush

@push('scripts')
    @vite([
        'resources/js/modules/tabulator.js',
        'Modules/Warehouse/resources/assets/js/warehouse.js',
    ], 'build/backend')
@endpush
