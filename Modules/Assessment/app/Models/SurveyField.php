<?php

namespace Modules\Assessment\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Assessment\Enums\FieldType;

/**
 * Đọc-chỉ tối thiểu bảng `survey_fields` — dùng để load danh sách câu hỏi khi cấu hình
 * scoring rule (AssessmentConfigController::getFields) và chấm điểm (AnswerReader đọc
 * trực tiếp survey_answers/survey_fields qua query builder, không qua model này).
 * Modules\Survey đã bị gỡ, bảng vẫn giữ dữ liệu lịch sử.
 */
class SurveyField extends Model
{
    protected $table = 'survey_fields';

    protected function casts(): array
    {
        return [
            'field_type'  => FieldType::class,
            'is_required' => 'boolean',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ];
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(SurveySection::class, 'section_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(SurveyFieldOption::class, 'field_id')->orderBy('sort_order');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
