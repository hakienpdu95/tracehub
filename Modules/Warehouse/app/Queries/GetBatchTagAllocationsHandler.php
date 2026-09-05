<?php

namespace Modules\Warehouse\Queries;

use App\Shared\Contracts\QueryHandlerInterface;
use App\Shared\Contracts\QueryInterface;
use Illuminate\Support\Collection;
use Modules\Warehouse\Models\RetailItemTag;
use Modules\Warehouse\Models\TagRoll;

class GetBatchTagAllocationsHandler implements QueryHandlerInterface
{
    /**
     * Gom nhóm tem của một lô thành các dải liên tục (Gaps and Islands) theo
     * visual_sequence + status. Tem cũ (sinh trước kiến trúc Tem Tiền định danh,
     * không có visual_sequence) được gom riêng theo status, không có dải số.
     *
     * @return array<int, array{prefix: ?string, from: ?int, to: ?int, count: int, status: \Modules\Warehouse\Enums\RetailItemTagStatus, updated_at: \Illuminate\Support\Carbon}>
     */
    public function handle(QueryInterface $query): array
    {
        /** @var GetBatchTagAllocationsQuery $query */
        $batch = $query->batch;

        $tags = RetailItemTag::where('batch_id', $batch->id)
            ->orderByRaw('visual_sequence IS NULL, visual_sequence ASC')
            ->get(['id', 'visual_sequence', 'status', 'updated_at']);

        $rolls = TagRoll::all(['prefix', 'from_sequence', 'to_sequence']);

        $segments = [];
        $current  = null;

        foreach ($tags as $tag) {
            $key = $tag->visual_sequence !== null ? 'seq|' . $tag->status->value : 'legacy|' . $tag->status->value;

            $extendsSequenced = $current
                && $current['key'] === $key
                && $tag->visual_sequence !== null
                && $current['to'] === $tag->visual_sequence - 1;

            $extendsLegacy = $current
                && $current['key'] === $key
                && $tag->visual_sequence === null
                && $current['to'] === null;

            if ($extendsSequenced || $extendsLegacy) {
                if ($tag->visual_sequence !== null) {
                    $current['to'] = $tag->visual_sequence;
                }
                $current['count']++;
                $current['updated_at'] = $tag->updated_at;
            } else {
                if ($current) {
                    $segments[] = $current;
                }

                $current = [
                    'key'        => $key,
                    'from'       => $tag->visual_sequence,
                    'to'         => $tag->visual_sequence,
                    'count'      => 1,
                    'status'     => $tag->status,
                    'updated_at' => $tag->updated_at,
                ];
            }
        }

        if ($current) {
            $segments[] = $current;
        }

        return array_map(fn (array $segment) => $this->attachPrefix($segment, $rolls), $segments);
    }

    /** @param Collection<int, TagRoll> $rolls */
    private function attachPrefix(array $segment, Collection $rolls): array
    {
        $segment['prefix'] = null;

        if ($segment['from'] !== null) {
            $roll = $rolls->first(fn (TagRoll $r) => $r->from_sequence <= $segment['from'] && $r->to_sequence >= $segment['to']);
            $segment['prefix'] = $roll?->prefix;
        }

        unset($segment['key']);

        return $segment;
    }
}
