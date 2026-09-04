<?php

namespace Modules\Assessment\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Đọc-chỉ tối thiểu bảng `surveys` — Modules\Survey đã bị gỡ (cleanup/remove-non-competency-modules)
 * nhưng bảng vẫn giữ dữ liệu lịch sử, cần cho engine chấm điểm Assessment.
 */
class Survey extends Model
{
    protected $table = 'surveys';

    protected function casts(): array
    {
        return [
            'status' => 'integer',
        ];
    }
}
