<?php

namespace Modules\Warehouse\Support;

use Illuminate\Support\Facades\DB;

class Gs1SerialGenerator
{
    private const ALPHABET = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    /**
     * Sinh $count chuỗi uid ngẫu nhiên, đảm bảo không trùng với dữ liệu đã có trong bảng.
     * uid dùng cho URL truy xuất công khai — phải ngẫu nhiên, không đoán được (chống dò dải).
     *
     * @return string[]
     */
    public function generateUids(int $count): array
    {
        $uids = [];

        while (count($uids) < $count) {
            $uids[$this->randomToken(12)] = true;
        }

        return $this->rejectCollisions(array_keys($uids));
    }

    /** @param string[] $uids @return string[] */
    private function rejectCollisions(array $uids): array
    {
        $existing = DB::table('retail_item_tags')->whereIn('uid', $uids)->pluck('uid')->all();

        if (empty($existing)) {
            return $uids;
        }

        $clean = array_values(array_diff($uids, $existing));

        return array_merge($clean, $this->generateUids(count($existing)));
    }

    /**
     * gs1_serial xác định (deterministic) từ prefix + visual_sequence đệm số 0 —
     * cho phép nhân viên kho lọc/gán theo dải bằng cách gõ đúng prefix + khoảng số nhìn thấy trên tem in.
     * Không cần chống trùng vì visual_sequence đã là duy nhất toàn hệ thống.
     */
    public function buildGs1Serial(string $prefix, int $visualSequence): string
    {
        $prefix = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $prefix));
        $digits = max(6, 20 - strlen($prefix));

        return substr($prefix . str_pad((string) $visualSequence, $digits, '0', STR_PAD_LEFT), 0, 20);
    }

    private function randomToken(int $length): string
    {
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= self::ALPHABET[random_int(0, strlen(self::ALPHABET) - 1)];
        }

        return $token;
    }
}
