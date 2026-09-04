<?php

namespace Modules\Assessment\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Đọc-chỉ tối thiểu bảng `survey_sections` — dùng cho sectioned aggregation trong
 * ScoringConfigLoader (Modules\Survey đã bị gỡ, bảng vẫn giữ dữ liệu lịch sử).
 */
class SurveySection extends Model
{
    protected $table = 'survey_sections';

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'min_score'  => 'integer',
            'max_score'  => 'integer',
        ];
    }
}
