<?php

namespace App\Classes\News\NewsProviders;

use Illuminate\Support\Facades\Http;

/**
 * Class TheGuardianNewsProvider. This class provides Classes and article from The Guardian website
 *
 * @author    Ramin Rezaei
 * @version   v1.0
 */
class TheGuardianNewsProvider extends AbstractNewsProvider
{
    /**
     * base url of The Guardian API
     */
    const BASE_URL = 'https://content.guardianapis.com/search';

    /**
     * @inheritDoc
     */
    public function search(string $searchedHash, string $query, int $page, array $categories, array $authors): array
    {

        $queryData = [
            'q' => $query,
            'api-key' => config('news.THEGUARDIAN_API_KEY'),
            'page-size' => AbstractNewsProvider::PAGE_SIZE,
            'show-fields' => 'byline',
            'page' => $page
        ];

        if (!empty($categories))
            $queryData['section'] = $this->createCategoriesQuery($categories);

        $response = Http::acceptJson()
            ->throw()
            ->get(self::BASE_URL, $queryData);

        return $this->convertToCustomFormat($searchedHash,
            $response->body());
    }

    /**
     * @param array $categories
     * @return string
     */
    private function createCategoriesQuery(array $categories): string
    {
        return $this->formatArrayToString($categories);
    }

    /**
     * @param array $input
     * @return string
     */
    private function formatArrayToString(array $input): string
    {
        return (str_replace(['[', ']', '"'], '', collect($input)->__toString()));
    }

    /**
     * converts The Guardian api output to the standard format
     * @param string $searchedQuery
     * @param string $json
     * @return array
     */
    private function convertToCustomFormat(string $searchedQuery, string $json): array
    {
        return collect(json_decode($json, true)['response']['results'])->map(function (array $article) use ($searchedQuery) {
            return (object)
            [
                'headline' => $article['webTitle'] ?? '',
                'category' => $article['sectionName'] ?? '',
                'pub_date' => $article['webPublicationDate'] ?? '',
                'web_url' => $article['webUrl'] ?? '',
                'author' => $article['fields']['byline'] ?? '',
                'source' => 'The Guardian' ?? '',
                'searched_query' => $searchedQuery
            ];
        })->toArray();
    }

    /**
     * this provider does not support categories
     * @inheritDoc
     */
    public function getCategories(): array
    {
        return array('');
    }
}
