function esc(v) {
    if (v == null) return '';
    return String(v)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function buildColumns() {
    return [
        {
            title: 'Mã đơn', field: 'order_number', minWidth: 200, sorter: 'string', frozen: true,
            formatter(cell) {
                const d = cell.getRow().getData();
                return '<a href="' + esc(d.show_url) + '" class="font-mono font-medium text-sm hover:text-primary transition-colors">'
                    + esc(d.order_number) + '</a>';
            },
        },
        {
            title: 'Đại lý', field: 'dealer_name', minWidth: 220, sorter: 'string',
            formatter(cell) {
                return esc(cell.getValue()) || '<span class="text-base-content/25 text-xs">—</span>';
            },
        },
        {
            title: 'Ngày lập', field: 'ordered_at', width: 130, hozAlign: 'center', sorter: 'string',
        },
        {
            title: 'Số dòng lô', field: 'picked_batches_count', width: 120, hozAlign: 'center', sorter: 'number',
        },
        {
            title: 'Trạng thái', field: 'status_value', width: 160, hozAlign: 'center', sorter: 'string',
            formatter(cell) {
                const d = cell.getRow().getData();
                return '<span class="badge ' + esc(d.status_badge) + ' badge-sm">' + esc(d.status_label) + '</span>';
            },
        },
        {
            title: 'Thao tác', field: 'id', width: 100, hozAlign: 'center', headerSort: false, frozen: true,
            formatter(cell) {
                const d = cell.getRow().getData();
                return '<a href="' + esc(d.show_url) + '" class="btn btn-ghost btn-xs">Xem</a>';
            },
        },
    ];
}

document.addEventListener('alpine:init', () => {

    Alpine.data('outboundOrderListPage', (serverData = {}) => {
        const {
            apiUrl   = '',
            statuses = [],
        } = serverData;

        const COLUMNS = buildColumns();

        let tableInst = null;

        return {
            filters: { status: '' },

            get hasFilters() {
                return !!this.filters.status;
            },

            get activeChips() {
                const chips = [], f = this.filters;
                if (f.status) {
                    const st = statuses.find(s => s.value === f.status);
                    chips.push({ key: 'status', label: st ? st.text : f.status });
                }
                return chips;
            },

            init() {
                this.loadState();
                this.$nextTick(() => this._setup());
            },

            _setup() {
                const self = this;

                tableInst = new window.Tabulator('#outbound-order-table', {
                    ajaxURL:    apiUrl,
                    ajaxConfig: { headers: { 'X-Requested-With': 'XMLHttpRequest' } },
                    ajaxParams() {
                        const p = {}, f = self.filters;
                        if (f.status) p.status = f.status;
                        return p;
                    },
                    ajaxResponse: (_u, _p, res) => res,
                    ajaxError: (error) => console.error('[outbound-order] API error', error),

                    pagination:             true,
                    paginationMode:         'remote',
                    paginationSize:         25,
                    paginationSizeSelector: [10, 25, 50, 100],
                    paginationCounter:      'rows',
                    sortMode:               'remote',
                    initialSort:            [{ column: 'ordered_at', dir: 'desc' }],

                    layout:           'fitColumns',
                    responsiveLayout: 'collapse',
                    movableColumns:   true,
                    height:           '68vh',

                    locale: 'vi-VN',
                    langs: {
                        'vi-VN': {
                            pagination: {
                                page_size: 'Dòng/trang', page_title: 'Trang',
                                first: '«', last: '»', prev: '‹', next: '›',
                                first_title: 'Trang đầu', last_title: 'Trang cuối',
                                prev_title: 'Trang trước', next_title: 'Trang sau',
                                counter: { showing: '', of: 'trong', rows: 'dòng', pages: 'trang' },
                            },
                        },
                    },

                    columns: COLUMNS,
                    placeholder: '<div class="py-16 text-center opacity-40">'
                        + '<svg class="w-12 h-12 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'
                        + '<p class="text-sm">Chưa có đơn xuất buôn nào</p></div>',
                });

                window.outboundOrderTable = tableInst;
            },

            loadState() {
                const p = new URLSearchParams(location.search);
                if (p.has('st')) this.filters.status = p.get('st');
            },

            saveState() {
                const p = new URLSearchParams(), f = this.filters;
                if (f.status) p.set('st', f.status);
                const qs = p.toString();
                history.replaceState(null, '', qs ? '?' + qs : location.pathname);
            },

            refresh()        { tableInst?.replaceData(); },
            onFilterChange() { this.saveState(); this.refresh(); },

            removeChip(key) {
                if (key === 'status') this.filters.status = '';
                this.saveState();
                this.refresh();
            },

            reset() {
                this.filters = { status: '' };
                history.replaceState(null, '', location.pathname);
                this.refresh();
            },
        };
    });
});
