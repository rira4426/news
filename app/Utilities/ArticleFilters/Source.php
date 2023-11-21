<?php

namespace App\Utilities\ArticleFilters;

use App\Utilities\FilterContract;
use App\Utilities\QueryFilter;

class Source extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->whereHas('source', function ($q) use ($value) {
            return $q->where('name', $value);
        });
    }
}
