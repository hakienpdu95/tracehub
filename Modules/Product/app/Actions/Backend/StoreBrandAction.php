<?php

namespace Modules\Product\Actions\Backend;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Product\Data\Requests\StoreBrandData;
use Modules\Product\Models\Brand;

class StoreBrandAction
{
    use AsAction;

    public function handle(StoreBrandData $data): Brand
    {
        return Brand::create([
            'name' => $data->name,
        ]);
    }
}
