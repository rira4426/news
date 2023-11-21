<?php

namespace App\Utilities\ArticleFilters;

use App\Utilities\FilterContract;
use App\Utilities\QueryFilter;

class Author extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->whereHas('authors', function ($q) use ($value) {
            return $q->where('name', $value);
        });
    }
}
