<?php

namespace Modules\Assessment\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Assessment\Contracts\ScoringSubjectInterface;
use Modules\Assessment\Engine\AnswerReader;

/**
 * Đọc-chỉ tối thiểu bảng `survey_responses` — nguồn dữ liệu đầu vào cho engine chấm điểm
 * (reprocessAll trong AssessmentConfigController). Modules\Survey đã bị gỡ cùng toàn bộ
 * luồng nộp khảo sát (SubmitSurveyAction, ResponseController...); bảng vẫn giữ dữ liệu
 * lịch sử nên vẫn tính lại được điểm cho các response đã có.
 */
class SurveyResponse extends Model implements ScoringSubjectInterface
{
    protected $table = 'survey_responses';

    protected function casts(): array
    {
        return [
            'submitted_at'          => 'datetime',
            'source_weight'         => 'float',
            'requires_human_review' => 'boolean',
        ];
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function scopeComplete(Builder $query): Builder
    {
        return $query->where('status', 1); // 1 = Complete (xem ResponseStatus gốc, module Survey đã gỡ)
    }

    // ── ScoringSubjectInterface ───────────────────────────────────────

    public function getScoringSubjectId(): int
    {
        return $this->id;
    }

    public function getScoringSubjectType(): string
    {
        return AssessmentResult::LEGACY_SURVEY_SUBJECT_TYPE;
    }

    public function getAssessmentCode(): string
    {
        return $this->survey?->assessment_code ?? '';
    }

    public function getScoringAnswers(): array
    {
        return app(AnswerReader::class)->read($this->id, $this->survey_id);
    }
}
