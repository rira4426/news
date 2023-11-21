<?php

namespace App\Utilities\ArticleFilters;

use App\Utilities\FilterContract;
use App\Utilities\QueryFilter;

class Headline extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('headline', $value);
    }
}
