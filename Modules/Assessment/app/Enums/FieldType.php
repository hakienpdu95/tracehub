<?php

namespace Modules\Assessment\Enums;

/**
 * Loại field của survey_fields — chỉ dùng để đọc câu hỏi phục vụ chấm điểm/cấu hình
 * (Modules\Survey đã bị gỡ, bảng survey_fields vẫn còn dữ liệu lịch sử).
 */
enum FieldType: int
{
    case Text     = 1;
    case Textarea = 2;
    case Number   = 3;
    case Select   = 4;
    case Radio    = 5;
    case Checkbox = 6;
    case Rating   = 7;
    case Date     = 8;
    case Boolean  = 9;
    case Matrix   = 10;
    case Ranking  = 11;
    case Nps      = 12;

    public function isChoice(): bool
    {
        return in_array($this, [self::Select, self::Radio, self::Checkbox]);
    }

    public function label(): string
    {
        return match ($this) {
            self::Text     => 'Văn bản ngắn',
            self::Textarea => 'Văn bản dài',
            self::Number   => 'Số',
            self::Select   => 'Dropdown',
            self::Radio    => 'Radio (chọn 1)',
            self::Checkbox => 'Checkbox (chọn nhiều)',
            self::Rating   => 'Đánh giá sao',
            self::Date     => 'Ngày tháng',
            self::Boolean  => 'Có / Không',
            self::Matrix   => 'Ma trận (grid)',
            self::Ranking  => 'Xếp hạng',
            self::Nps      => 'NPS (0–10)',
        };
    }
}
