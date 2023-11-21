<?php

namespace App\Classes\News\NewsProviders;

use Illuminate\Support\Facades\Http;

/**
 * Class NYTimesNewsProvider. This class provides Classes and article from NYTimes website
 *
 * @author    Ramin Rezaei
 * @version   v1.0
 */
class NYTimesNewsProvider extends AbstractNewsProvider
{

    /**
     * base url of the NYTimes API
     */
    const BASE_URL = 'https://api.nytimes.com/svc/search/v2/articlesearch.json';

    /**
     * @inheritDoc
     */
    public function search(string $searchedHash, string $query, int $page, array $categories, array $authors): array
    {
        $fq = 'source:("The New York Times")'
            . (empty($categories) ? '' : $this->createCategoriesQuery($categories))
            . (empty($authors) ? '' : $this->createAuthorsQuery($authors));

        $response = Http::acceptJson()
            ->throw()
            ->get(self::BASE_URL, [
                'q' => $query,
                'api-key' => config('news.NYTIMES_API_KEY'),
                'fl' => 'web_url, headline, pub_date, news_desk, byline, source',
                'fq' => $fq,
                'page-size' => AbstractNewsProvider::PAGE_SIZE,
                'page' => $page
            ]);

        return $this->convertToCustomFormat($searchedHash, $response->body());
    }

    /**
     * @param array $authors
     * @return string
     */
    private function createAuthorsQuery(array $authors): string
    {
        return ' AND byline:(' . $this->formatArrayToString($authors) . ')';
    }

    /**
     * @param array $categories
     * @return string
     */
    private function createCategoriesQuery(array $categories): string
    {
        return ' AND news_desk:(' . $this->formatArrayToString($categories) . ')';
    }

    /**
     * @param array $input
     * @return string
     */
    private function formatArrayToString(array $input): string
    {
        return (str_replace(['[', ']'], '', collect($input)->__toString()));
    }

    /**
     * converts the NYTimes api output to the standard format
     * @param string $json
     * @return array
     */
    private function convertToCustomFormat(string $searchedQuery, string $json): array
    {
        return collect(json_decode($json, true)['response']['docs'])->map(function (array $article) use ($searchedQuery) {
            return (object)
            [
                'headline' => $article['headline']['main'] ?? '',
                'category' => $article['news_desk'] ?? '',
                'pub_date' => $article['pub_date'] ?? '',
                'web_url' => $article['web_url'] ?? '',
                'author' => $article['byline']['original'] ?? '',
                'source' => $article['source'] ?? '',
                'searched_query' => $searchedQuery
            ];
        })->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getCategories(): array
    {
        return array("Adventure Sports", "Arts & Leisure", "Arts", "Automobiles", "Blogs", "Books", "Booming", "Business Day", "Business", "Cars", "Circuits", "Classifieds", "Connecticut", "Crosswords & Games", "Culture", "DealBook", "Dining", "Editorial", "Education", "Energy", "Entrepreneurs", "Environment", "Escapes", "Fashion & Style", "Fashion", "Favorites", "Financial", "Flight", "Food", "Foreign", "Generations", "Giving", "Global Home", "Health & Fitness", "Health", "Home & Garden", "Home", "Jobs", "Key", "Letters", "Long Island", "Magazine", "Market Place", "Media", "Men's Health", "Metro", "Metropolitan", "Movies", "Museums", "National", "Nesting", "Obits", "Obituaries", "Obituary", "OpEd", "Opinion", "Outlook", "Personal Investing", "Personal Tech", "Play", "Politics", "Regionals", "Retail", "Retirement", "Science", "Small Business", "Society", "Sports", "Style", "Sunday Business", "Sunday Review", "Sunday Styles", "T Magazine", "T Style", "Technology", "Teens", "Television", "The Arts", "The Business of Green", "The City Desk", "The City", "The Marathon", "The Millennium", "The Natural World", "The Upshot", "The Weekend", "The Year in Pictures", "Theater", "Then & Now", "Thursday Styles", "Times Topics", "Travel", "U.S.", "Universal", "Upshot", "UrbanEye", "Vacation", "Washington", "Wealth", "Weather", "Week in Review", "Week", "Weekend", "Westchester", "Wireless Living", "Women's Health", "Working", "Workplace", "World", "Your Money");
    }
}
