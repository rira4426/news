<?php

namespace App\Http\Controllers;


use App\Http\Requests\SearchNewsRequest;
use App\Interfaces\NewsProviderInterface;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Search;
use App\Models\Source;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class SearchNewsController extends Controller
{

    private NewsProviderInterface $newsService;

    public function __construct(NewsProviderInterface $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @param SearchNewsRequest $request
     * @return Collection
     * @throws ValidationException
     */
    public function searchNews(SearchNewsRequest $request): Collection
    {
        $sanitizedData = $request->validated();

        $searchedHash = $this->generateHash($request);

        $results = $this->getSearchHistory($searchedHash);
        if (!$results) {
            $results = $this->newsService->search($searchedHash, $sanitizedData['providers'], $sanitizedData['query'], $sanitizedData['page'],
                $sanitizedData['categories'] ?? [], $sanitizedData['authors'] ?? []);
            $this->saveData($results);
        }

        $results = $this->getSearchHistory($searchedHash);

        return Article::with('authors')
            ->with('category')
            ->with('source')
            ->where('search_id', $results->id)
            ->filterBy(request()->all())->get();
    }

    /**
     * @param SearchNewsRequest $sanitizedData
     * @return string
     */
    private function generateHash(SearchNewsRequest $sanitizedData): string
    {
        $hashable = $sanitizedData->safe()->only(['providers', 'query', 'categories', 'authors']);
        return sha1(serialize($hashable) . Carbon::now()->format('Y-m-d H:i'));
    }


    /**
     * @param string $searchedHash
     * @return null|Search
     */
    private function getSearchHistory(string $searchedHash): null|Search
    {
        return Search::where('hash', $searchedHash)->where('expire', '>=', Carbon::now())->first();
    }


    /**
     * @param array $results
     */
    private function saveData(array $results): void
    {
        $collection = collect($results);
        $collection->map(function ($value) {
            $authors = $this->getAuthors($value);

            $this->insertToDB($authors, $value);

            return $value;
        });
    }

    /**
     * @param $value
     * @return array
     */
    private function getAuthors($value): array
    {
        $c = collect(preg_split("/ and |[,]/", $value->author, -1, PREG_SPLIT_NO_EMPTY));
        $keyed = $c->mapWithKeys(function ($item, $index) {
            return ['name' => $item];
//            return [$index => ['name' => $item]];
        });
        return $keyed->toArray();
    }

    /**
     * @param array $authors
     * @param $value
     * @return void
     */
    private function insertToDB(array $authors, $value): void
    {
        Article::factory()
            ->hasAttached(
                Author::firstOrCreate(
                    $authors
                )
            )
            ->for(Source::firstOrCreate([
                'name' => $value->source,
            ]))
            ->for(Category::firstOrCreate([
                'name' => $value->category,
            ]))
            ->for(Search::firstOrCreate(
                ['hash' => $value->searched_query],
                [
                    'hash' => $value->searched_query,
                    'query' => $value->searched_query,
                    'expire' => Carbon::now()->addMinute(),
                ]))
            ->create([
                'headline' => $value->headline,
                'pub_date' => Carbon::parse($value->pub_date)->toDateTimeString(),
                'web_url' => $value->web_url
            ]);
    }
}
