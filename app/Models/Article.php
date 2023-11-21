<?php

namespace App\Models;

use App\Utilities\FilterBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function search()
    {
        return $this->belongsTo(Search::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function scopeFilterBy($query, $filters)
    {
        $filterClassNamespace = 'App\Utilities\ArticleFilters';

        $filter = new FilterBuilder($filterClassNamespace, $query, $filters);

        return $filter->apply();
    }
}
