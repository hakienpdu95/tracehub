<?php

namespace Modules\Assessment\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AssessmentResult extends Model
{
    protected $table = 'assessment_results';

    protected $fillable = [
        'subject_type',
        'subject_id',
        'overall_score',
        'maturity_level',
        'assessment_code',
        'weight_version',
        'calculated_at',
        'public_token',
    ];

    protected function casts(): array
    {
        return [
            'overall_score'  => 'float',
            'weight_version' => 'integer',
            'calculated_at'  => 'datetime',
        ];
    }

    // ── Polymorphic subject ───────────────────────────────────────────

    public function subject(): MorphTo
    {
        return $this->morphTo('subject');
    }

    // ── Child relations ───────────────────────────────────────────────

    public function domainScores(): HasMany
    {
        return $this->hasMany(ResultDomainScore::class, 'result_id');
    }

    public function signalFlags(): HasMany
    {
        return $this->hasMany(ResultSignalFlag::class, 'result_id');
    }

    public function painPoints(): HasMany
    {
        return $this->hasMany(ResultPainPoint::class, 'result_id');
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(ResultRecommendation::class, 'result_id')->orderBy('priority');
    }

    public function roadmapPhases(): HasMany
    {
        return $this->hasMany(ResultRoadmapPhase::class, 'result_id')->orderBy('sort_order');
    }

    public function questionScores(): HasMany
    {
        return $this->hasMany(ResultQuestionScore::class, 'result_id');
    }

    public function classification(): HasOne
    {
        return $this->hasOne(ResultClassification::class, 'result_id');
    }

    public function feedback(): HasOne
    {
        return $this->hasOne(ScoringFeedback::class, 'result_id');
    }

    // Giá trị subject_type lịch sử cho các result sinh ra từ SurveyResponse — giữ nguyên
    // chuỗi này (dù Modules\Survey đã bị gỡ) để không phá vỡ các dòng assessment_results
    // đã lưu trước đó. Xem Modules\Assessment\Models\SurveyResponse::getScoringSubjectType().
    public const LEGACY_SURVEY_SUBJECT_TYPE = 'Modules\Survey\Models\SurveyResponse';

    // ── Scopes ────────────────────────────────────────────────────────

    public static function forSubject(string $subjectType, int $subjectId): Builder
    {
        return static::query()
            ->where('subject_type', $subjectType)
            ->where('subject_id', $subjectId);
    }
}
