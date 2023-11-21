<?php

namespace App\Utilities\ArticleFilters;

use App\Utilities\FilterContract;
use App\Utilities\QueryFilter;

class Category extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->whereHas('category', function ($q) use ($value) {
            return $q->where('name', $value);
        });
    }
}
