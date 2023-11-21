<?php

namespace App\Classes\News\NewsProviders;

use App\Interfaces\CategorizeInterface;
use App\Interfaces\SearchInterface;

/**
 * Class AbstractNewsProvider every provider should follow the same rule
 *
 * @author    Ramin Rezaei
 * @version   v1.0
 */
abstract class AbstractNewsProvider implements SearchInterface, CategorizeInterface
{
    /**
     * Page Size for pagination
     */
    public const PAGE_SIZE = 10;
}
