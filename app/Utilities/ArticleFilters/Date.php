<?php

namespace App\Utilities\ArticleFilters;

use App\Utilities\FilterContract;
use App\Utilities\QueryFilter;

class Date extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->whereDate('pub_date', '=', $value);
    }
}
