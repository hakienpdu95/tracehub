<aside class="sidebar" id="sidebar">

    <div class="brand">
        <div class="brand-logo">
            <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" class="brand-logo-img">
        </div>
        {{-- brand-name ẩn: tên đã có trong logo image --}}
    </div>

    <nav class="nav-wrap">
        <p class="section-title">Chính</p>
        <div class="nav-group">
            <a href="{{ route('backend.dashboard') }}"
               class="nav-link {{ request()->routeIs('backend.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="nav-label">Dashboard</span>
            </a>

            {{-- Survey (Modules\Survey đã bị gỡ cùng module đó — cleanup/remove-non-competency-modules) --}}
        </div>

        {{-- Business Consulting OS (Business Project/Lead/Customer/Task/KC/SOP) đã bị
             gỡ cùng các module đó (cleanup/remove-non-competency-modules). --}}

        {{--
            ══════════════════════════════════════════════════════════════════
            TỔ CHỨC — hạ tầng tổ chức/dùng chung, KHÔNG riêng BCOS cũng KHÔNG
            thuộc nhóm "module khác" (Project là công cụ nền tảng dùng nhiều
            nơi, không phải nghiệp vụ tư vấn cũng không phải khối thừa/HR/
            Marketplace). AI Copilot và RoleScope (Phân quyền phạm vi/
            Delegation/Permission Catalog) đã bị gỡ (cleanup/remove-non-competency-modules).
            ══════════════════════════════════════════════════════════════════
        --}}
        <p class="section-title" style="margin-top:16px;">Tổ chức</p>
        <div class="nav-group">

            <details {{ request()->routeIs('backend.organizations.*') ? 'open' : '' }}>
                <summary class="nav-summary {{ request()->routeIs('backend.organizations.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span class="nav-label">Tổ chức</span>
                    <svg class="nav-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 18 6-6-6-6"/></svg>
                </summary>
                <div class="sub-menu">
                    <a href="{{ route('backend.organizations.index') }}" class="sub-link {{ request()->routeIs('backend.organizations.index') ? 'active' : '' }}">Danh sách tổ chức</a>
                    <a href="{{ route('backend.organizations.create') }}" class="sub-link {{ request()->routeIs('backend.organizations.create') ? 'active' : '' }}">Thêm tổ chức</a>
                </div>
            </details>

            @can('vendor.view')
            <details {{ request()->routeIs('backend.vendors.*') ? 'open' : '' }}>
                <summary class="nav-summary {{ request()->routeIs('backend.vendors.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h18v4H3V3zm2 4h14v14H5V7zm3 4h8m-8 4h5"/></svg>
                    <span class="nav-label">Nhà cung cấp</span>
                    <svg class="nav-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 18 6-6-6-6"/></svg>
                </summary>
                <div class="sub-menu">
                    <a href="{{ route('backend.vendors.index') }}" class="sub-link {{ request()->routeIs('backend.vendors.index') ? 'active' : '' }}">Danh sách nhà cung cấp</a>
                    @can('vendor.manage')
                    <a href="{{ route('backend.vendors.create') }}" class="sub-link {{ request()->routeIs('backend.vendors.create') ? 'active' : '' }}">Thêm nhà cung cấp</a>
                    @endcan
                </div>
            </details>
            @endcan

            @can('product.view')
            <details {{ request()->routeIs('backend.products.*', 'backend.brands.*', 'backend.document-master-types.*') ? 'open' : '' }}>
                <summary class="nav-summary {{ request()->routeIs('backend.products.*', 'backend.brands.*', 'backend.document-master-types.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span class="nav-label">Danh mục sản phẩm</span>
                    <svg class="nav-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 18 6-6-6-6"/></svg>
                </summary>
                <div class="sub-menu">
                    <a href="{{ route('backend.products.index') }}" class="sub-link {{ request()->routeIs('backend.products.index') ? 'active' : '' }}">Danh sách sản phẩm</a>
                    @can('product.manage')
                    <a href="{{ route('backend.products.create') }}" class="sub-link {{ request()->routeIs('backend.products.create') ? 'active' : '' }}">Thêm sản phẩm</a>
                    <a href="{{ route('backend.brands.index') }}" class="sub-link {{ request()->routeIs('backend.brands.*') ? 'active' : '' }}">Thương hiệu</a>
                    <a href="{{ route('backend.document-master-types.index') }}" class="sub-link {{ request()->routeIs('backend.document-master-types.*') ? 'active' : '' }}">Từ điển giấy tờ pháp lý</a>
                    @endcan
                </div>
            </details>
            @endcan

            @can('warehouse.view')
            <details {{ request()->routeIs('backend.inbound-receipts.*', 'backend.batches.*', 'backend.outbound-orders.*', 'backend.tag-rolls.*', 'backend.tag-scan-bind.*', 'backend.serial-lookup.*') ? 'open' : '' }}>
                <summary class="nav-summary {{ request()->routeIs('backend.inbound-receipts.*', 'backend.batches.*', 'backend.outbound-orders.*', 'backend.tag-rolls.*', 'backend.tag-scan-bind.*', 'backend.serial-lookup.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 8l-9-5-9 5m18 0l-9 5m9-5v10l-9 5m0-10L3 8m9 5v10M3 8v10l9 5"/></svg>
                    <span class="nav-label">Kho & Truy xuất nguồn gốc</span>
                    <svg class="nav-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 18 6-6-6-6"/></svg>
                </summary>
                <div class="sub-menu">
                    <a href="{{ route('backend.inbound-receipts.index') }}" class="sub-link {{ request()->routeIs('backend.inbound-receipts.index') ? 'active' : '' }}">Phiếu nhập kho</a>
                    @can('warehouse.manage')
                    <a href="{{ route('backend.inbound-receipts.create') }}" class="sub-link {{ request()->routeIs('backend.inbound-receipts.create') ? 'active' : '' }}">Tạo phiếu nhập</a>
                    @endcan
                    <a href="{{ route('backend.batches.index') }}" class="sub-link {{ request()->routeIs('backend.batches.*') ? 'active' : '' }}">Lô hàng</a>
                    <a href="{{ route('backend.outbound-orders.index') }}" class="sub-link {{ request()->routeIs('backend.outbound-orders.*') ? 'active' : '' }}">Đơn xuất buôn (B2B)</a>
                    <a href="{{ route('backend.serial-lookup.index') }}" class="sub-link {{ request()->routeIs('backend.serial-lookup.*') ? 'active' : '' }}">Tra cứu vòng đời Serial</a>
                    @can('warehouse.manage')
                    <a href="{{ route('backend.tag-rolls.index') }}" class="sub-link {{ request()->routeIs('backend.tag-rolls.*') ? 'active' : '' }}">Kho tem tiền định danh</a>
                    <a href="{{ route('backend.tag-scan-bind.create') }}" class="sub-link {{ request()->routeIs('backend.tag-scan-bind.*') ? 'active' : '' }}">Gắn kết rời rạc (quét mã)</a>
                    @endcan
                </div>
            </details>
            @endcan

            @can('recall.view')
            <details {{ request()->routeIs('backend.product-recalls.*', 'backend.adverse-event-reports.*') ? 'open' : '' }}>
                <summary class="nav-summary {{ request()->routeIs('backend.product-recalls.*', 'backend.adverse-event-reports.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    <span class="nav-label">Thu hồi & Sự cố</span>
                    <svg class="nav-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 18 6-6-6-6"/></svg>
                </summary>
                <div class="sub-menu">
                    <a href="{{ route('backend.product-recalls.index') }}" class="sub-link {{ request()->routeIs('backend.product-recalls.*') ? 'active' : '' }}">Chiến dịch thu hồi</a>
                    <a href="{{ route('backend.adverse-event-reports.index') }}" class="sub-link {{ request()->routeIs('backend.adverse-event-reports.*') ? 'active' : '' }}">Báo cáo tác dụng bất lợi</a>
                </div>
            </details>
            @endcan

            @can('compliance.view')
            <a href="{{ route('backend.compliance-warnings.index') }}"
               class="nav-link {{ request()->routeIs('backend.compliance-warnings.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                <span class="nav-label">Cảnh báo pháp lý & hạn dùng</span>
            </a>
            @endcan

            {{-- Project đã bị gỡ (cleanup/remove-non-competency-modules). --}}

            {{-- AI Copilot (Usage Dashboard/Request Logs/AI Agents/Prompt Library) và
                 Phân quyền phạm vi/Delegation/Permission Catalog (RoleScope) đã bị gỡ
                 (cleanup/remove-non-competency-modules). --}}

        </div>

        <p class="section-title" style="margin-top:16px;">Tài khoản</p>
        <div class="nav-group">

            <details {{ request()->routeIs('backend.users.*') ? 'open' : '' }}>
                <summary class="nav-summary {{ request()->routeIs('backend.users.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="nav-label">Tài khoản</span>
                    <svg class="nav-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 18 6-6-6-6"/></svg>
                </summary>
                <div class="sub-menu">
                    <a href="{{ route('backend.users.index') }}" class="sub-link {{ request()->routeIs('backend.users.index') ? 'active' : '' }}">Danh sách tài khoản</a>
                    <a href="{{ route('backend.users.create') }}" class="sub-link {{ request()->routeIs('backend.users.create') ? 'active' : '' }}">Thêm tài khoản</a>
                </div>
            </details>

            <a href="{{ route('backend.notifications.index') }}"
               class="nav-link {{ request()->routeIs('backend.notifications.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="nav-label">Thông báo</span>
            </a>

        </div>

        <p class="section-title" style="margin-top:16px;">Hệ thống</p>
        <div class="nav-group">

            @can('activitylog.view')
            <details {{ request()->routeIs('activitylog.*') ? 'open' : '' }}>
                <summary class="nav-summary {{ request()->routeIs('activitylog.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="nav-label">Activity Log</span>
                    <svg class="nav-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 18 6-6-6-6"/></svg>
                </summary>
                <div class="sub-menu">
                    <a href="{{ route('activitylog.index') }}"
                       class="sub-link {{ request()->routeIs('activitylog.index') ? 'active' : '' }}">
                       Danh sách log
                    </a>
                </div>
            </details>
            @endcan

            {{-- Workflow monitor đã bị gỡ cùng module WorkflowAutomation
                 (cleanup/remove-non-competency-modules). --}}

            {{-- Export Request đã bị gỡ (cleanup/remove-non-competency-modules). --}}

        </div>

        {{-- "Phân tích"/Report đã bị gỡ cùng module Report (cleanup/remove-non-competency-modules). --}}

        {{--
            ══════════════════════════════════════════════════════════════════
            MODULE KHÁC — mọi module KHÔNG thuộc luồng BCOS (xem spec Phần 8.2).
            Chi nhánh/Phòng ban/Vị trí/Nhân viên/Nghỉ phép/KPI/Đánh giá hiệu suất/
            Sơ đồ tổ chức, Recruitment/JobPosting, Marketplace, OCOP,
            Subscription/Billing, Sandbox/Certifications/Career Pathway/AI Impact/
            Career Journal/Assessment Marketplace, và toàn bộ hệ sinh thái
            Deployment/BusinessSolution/Blueprint/Vertical Template đã bị gỡ
            (cleanup/remove-non-competency-modules). Còn lại: Chức danh, Person,
            Invitations, Digital Twin (Chấm điểm + hồ sơ năng lực số).
            ══════════════════════════════════════════════════════════════════
        --}}
        <p class="section-title" style="margin-top:16px;">Module khác</p>
        <div class="nav-group">

            {{-- Chấm điểm (Assessment) đã bị gỡ cùng module Assessment (cleanup/remove-non-competency-modules). --}}

            {{-- Vertical Template / Business Solution/Business Blueprint admin đã bị gỡ cùng
                 các module đó (cleanup/remove-non-competency-modules). --}}

            {{-- Chức danh (JobTitle), Person/Invitations/Import cơ cấu, Chi nhánh/Phòng ban/Vị trí/Nhân viên/Leave/
                 KpiGoal/PerformanceReview/OrgChart
                 đã bị gỡ cùng các module đó (cleanup/remove-non-competency-modules). --}}

            {{-- JobPosting/Marketplace/Recruitment/Subscription đã bị gỡ cùng các module đó
                 (cleanup/remove-non-competency-modules). --}}

            {{-- Digital Twin (Hồ sơ Digital Twin/Workforce Admin), Sandbox/Certifications/
                 Career Pathway/AI Impact/Career Journal/Assessment Marketplace đã bị gỡ cùng
                 các tính năng đó (cleanup/remove-non-competency-modules). --}}

            {{-- "Hub triển khai" (Deployment) đã bị gỡ cùng module Deployment
                 (cleanup/remove-non-competency-modules). --}}

        </div>

    </nav>
</aside>
