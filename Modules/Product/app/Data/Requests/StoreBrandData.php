<?php

namespace Modules\Product\Data\Requests;

use App\Shared\Tenancy\TenantContext;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class StoreBrandData extends Data
{
    public function __construct(
        #[Required, StringType, Max(150)]
        public readonly string $name,
    ) {}

    public static function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'max:150',
                Rule::unique('brands', 'name')->where('organization_id', TenantContext::getOrganizationId()),
            ],
        ];
    }

    public static function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên thương hiệu.',
            'name.string'   => 'Tên thương hiệu không hợp lệ.',
            'name.max'      => 'Tên thương hiệu không được vượt quá 150 ký tự.',
            'name.unique'   => 'Thương hiệu này đã tồn tại.',
        ];
    }
}
