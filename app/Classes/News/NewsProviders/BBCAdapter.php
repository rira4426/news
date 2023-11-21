<?php

namespace App\Classes\News\NewsProviders;

use jcobhams\NewsApi\NewsApi;

/**
 * Class NewsAPINewsProviderBBCAdapter. This class uses standard newsapi package and performs as an adapter
 * This class uses adapter design pattern
 * @author    Ramin Rezaei
 * @version   v1.0
 */
class BBCAdapter extends AbstractNewsProvider
{
    /**
     * Classes api object which uses standard newsapi package
     */
    private $newsapi;

    /**
     * init newapi object with api key to access the server
     */
    public function __construct()
    {
        $this->newsapi = new NewsApi(config('news.NEWSAPI_API_KEY'));
    }

    /**
     * @inheritDoc
     * @throws \jcobhams\NewsApi\NewsApiException
     */
    public function search(string $searchedHash,string $query, int $page, array $categories, array $authors): array
    {
        $result = json_decode(
            json_encode($this->newsapi->getEverything($query,
                'bbc-news', null, null, null,
                null, null, null, AbstractNewsProvider::PAGE_SIZE, $page))
            , true);
        return $this->convertToCustomFormat($searchedHash, $result);
    }

    /**
     * converts the newsapi api output to the standard format
     * @param array $json
     * @return array
     */
    private function convertToCustomFormat(string $searchedQuery, array $json): array
    {
        return collect($json['articles'])->map(function (array $article) use ($searchedQuery) {
            return (object)
            [
                'headline' => $article['title'] ?? '',
                'category' => $article['category'] ?? '',
                'pub_date' => $article['publishedAt'] ?? '',
                'web_url' => $article['url'] ?? '',
                'author' => $article['author'] ?? '',
                'source' => $article['source']['name'] ?? '',
                'searched_query' => $searchedQuery
            ];
        })->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getCategories(): array
    {
        return $this->newsapi->getCategories();
    }
}
