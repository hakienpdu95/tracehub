<?php
namespace App\Enums;

enum PermissionEnum: string
{
    // ══ CEO DASHBOARD ══════════════════════════════════════════════
    // CEO=Full | Ops=Limited | AI_OP=Limited | Admin=Config | Viewer=View limited
    case CEO_DASH_FULL   = 'ceo_dashboard.full';    // CEO
    case CEO_DASH_VIEW   = 'ceo_dashboard.view';    // Ops(limited), AI_OP(limited), Viewer
    case CEO_DASH_CONFIG = 'ceo_dashboard.config';  // System Admin

    // ══ SALES AI ═══════════════════════════════════════════════════
    // CEO=Full | Sales=Use | Marketing=Limited | AI_OP=Config prompt | Admin=Config
    case SALES_AI_VIEW          = 'sales_ai.view';          // CEO(full), Marketing(limited)
    case SALES_AI_USE           = 'sales_ai.use';           // Sales — gọi AI, nhận output
    case SALES_AI_CONFIG_PROMPT = 'sales_ai.config_prompt'; // AI Operator
    case SALES_AI_CONFIG        = 'sales_ai.config';        // System Admin

    // ══ PROMPT MANAGEMENT ══════════════════════════════════════════
    // CEO=View | AI_OP=Full | Admin=Admin config
    case PROMPT_VIEW         = 'prompt.view';         // CEO (read-only)
    case PROMPT_FULL         = 'prompt.full';         // AI Operator
    case PROMPT_ADMIN_CONFIG = 'prompt.admin_config'; // System Admin

    // ══ AI LOGS ════════════════════════════════════════════════════
    // CEO=View summary | Ops=Limited | AI_OP=Full | Admin=Full
    case AI_LOGS_FULL    = 'ai_logs.full';    // AI Operator, Admin
    case AI_LOGS_VIEW    = 'ai_logs.view';    // CEO(summary), Ops(limited)

    // ══ AI COPILOT ═════════════════════════════════════════════════
    // CEO=Use+ViewUsage | Sales=Use | Ops=Use | HR=Use | Marketing=Use | AI_OP=Use+Config | Admin=Use+Config
    case AI_COPILOT_USE        = 'ai_copilot.use';        // Sử dụng AI task execution
    case AI_COPILOT_CONFIG     = 'ai_copilot.config';     // Quản lý agents + prompts
    case AI_COPILOT_VIEW_USAGE = 'ai_copilot.view_usage'; // Xem usage stats / logs

    // ══ USERS ══════════════════════════════════════════════════════
    // CEO=View | HR=Limited | Admin=Full
    case USERS_VIEW   = 'users.view';   // CEO
    case USERS_HR     = 'users.hr';     // HR (tạo user nội bộ, onboarding)
    case USERS_MANAGE = 'users.manage'; // System Admin

    // ══ ROLES & PERMISSIONS ════════════════════════════════════════
    // Admin=Full only
    case ROLES_MANAGE = 'roles.manage';

    // ══ ASSESSMENT (Chấm điểm khảo sát) ═══════════════════════════
    // CEO=View | Ops=View | AI_OP=Config+Reprocess | Admin=Full
    case ASSESSMENT_VIEW      = 'assessment.view';      // CEO, Ops, AI_OP — xem danh sách assessments
    case ASSESSMENT_CONFIG    = 'assessment.config';    // AI_OP, Admin — wizard cấu hình
    case ASSESSMENT_RESULTS   = 'assessment.results';   // CEO, Ops, AI_OP — xem kết quả
    case ASSESSMENT_REPROCESS = 'assessment.reprocess'; // AI_OP, Admin — force recalculate

    // ══ SUBSCRIPTION ═══════════════════════════════════════════════
    // Chỉ còn VIEW — MANAGE/BILLING/ADMIN gate các route quản trị thuộc
    // Modules/Subscription (đã xóa, xem cleanup/remove-non-competency-modules).
    // VIEW vẫn hợp lệ: hiển thị thông tin plan hiện tại qua vendor package
    // laravelcm/laravel-subscriptions (Modules/Organization/resources/views/show.blade.php),
    // không phụ thuộc module đã xóa.
    case SUBSCRIPTION_VIEW = 'subscription.view';

    // ══ SYSTEM ═════════════════════════════════════════════════════
    case INTEGRATION_MANAGE = 'integration.manage';
    case AUDIT_VIEW         = 'audit.view';
    case SYSTEM_CONFIG      = 'system.config';

    // ── Export dữ liệu nhạy cảm (GAP_ANALYSIS_v1.0.md §3.3 OPS-02) ──
    case EXPORT_REQUEST_VIEW    = 'export_request.view';    // Xem Export Request register (minh bạch nội bộ)
    case EXPORT_REQUEST_APPROVE = 'export_request.approve'; // Phê duyệt/từ chối — SoD, không tự duyệt request của mình
}
