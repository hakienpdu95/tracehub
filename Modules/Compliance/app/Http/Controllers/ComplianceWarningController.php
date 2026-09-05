<?php

namespace Modules\Compliance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Compliance\Actions\AcknowledgeWarningAction;
use Modules\Compliance\Actions\ResolveWarningAction;
use Modules\Compliance\Enums\WarningCategory;
use Modules\Compliance\Enums\WarningSeverity;
use Modules\Compliance\Enums\WarningStatus;
use Modules\Compliance\Models\ComplianceWarning;
use Modules\Compliance\Queries\ListWarningsHandler;
use Modules\Compliance\Queries\ListWarningsQuery;

class ComplianceWarningController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ComplianceWarning::class, 'warning');
    }

    public function index(Request $request, ListWarningsHandler $handler)
    {
        $warnings = $handler->handle(new ListWarningsQuery(
            page:     max(1, (int) $request->integer('page', 1)),
            perPage:  25,
            status:   $request->input('status'),
            category: $request->input('category'),
            severity: $request->input('severity'),
        ));

        $statuses   = collect(WarningStatus::cases())->map(fn ($s) => ['value' => $s->value, 'label' => $s->label()])->all();
        $categories = collect(WarningCategory::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()])->all();
        $severities = collect(WarningSeverity::cases())->map(fn ($s) => ['value' => $s->value, 'label' => $s->label()])->all();

        return view('compliance::warnings.index', compact('warnings', 'statuses', 'categories', 'severities'));
    }

    public function acknowledge(ComplianceWarning $warning, AcknowledgeWarningAction $action): RedirectResponse
    {
        $this->authorize('update', $warning);

        $action->handle($warning);

        return redirect()->route('backend.compliance-warnings.index')
            ->with('success', 'Đã ghi nhận cảnh báo.');
    }

    public function resolve(ComplianceWarning $warning, ResolveWarningAction $action): RedirectResponse
    {
        $this->authorize('update', $warning);

        $action->handle($warning);

        return redirect()->route('backend.compliance-warnings.index')
            ->with('success', 'Đã đánh dấu cảnh báo là xử lý xong.');
    }
}
