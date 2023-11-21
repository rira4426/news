<?php

namespace App\Services\News;

use App\Classes\News\NewsSourceFactory;
use App\Interfaces\NewsProviderInterface;

/**
 * Class NewsService
 *
 * @author    Ramin Rezaei
 * @version   v1.0
 *
 */
class NewsService implements NewsProviderInterface
{

    /**
     * @param string $searchedHash
     * @param array $providers
     * @param string $query
     * @param int $page
     * @param array $categories
     * @param array $authors
     * @return array
     */
    public function search(string $searchedHash, array $providers, string $query, int $page, array $categories, array $authors): array
    {
        $merged = collect([]);

        foreach ($providers as $provider) {
            $newsProvider = NewsSourceFactory::make($provider);
            $merged = $merged->merge(collect($newsProvider->search($searchedHash, $query, $page, $categories, $authors)));
        }

        return $merged->all();
    }
}
