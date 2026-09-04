<?php

namespace Modules\Assessment\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Đọc-chỉ tối thiểu bảng `survey_field_options` (Modules\Survey đã bị gỡ).
 */
class SurveyFieldOption extends Model
{
    protected $table = 'survey_field_options';

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_other'   => 'boolean',
        ];
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
