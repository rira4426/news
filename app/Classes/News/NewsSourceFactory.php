<?php

namespace App\Classes\News;

use App\Classes\News\NewsProviders\AbstractNewsProvider;
use App\Classes\News\NewsProviders\NYTimesNewsProvider;
use App\Classes\News\NewsProviders\BBCAdapter;
use App\Classes\News\NewsProviders\TheGuardianNewsProvider;

/**
 * Class NewsSourceFactory is responsible to create provider based on Factory design pattern
 *
 * @author    Ramin Rezaei
 * @version   v1.0
 */
class NewsSourceFactory
{
    /**
     * @param string $type
     * @return AbstractNewsProvider
     */
    public static function make(string $type): AbstractNewsProvider
    {
        return match ($type) {
            "nytimes" => new NYTimesNewsProvider(),
            "bbc" => new BBCAdapter(),
            "theguardian" => new TheGuardianNewsProvider(),
        };
    }
}
