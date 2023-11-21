<?php

namespace App\Interfaces;

interface SearchInterface
{
    /**
     * search for articles and Classes
     * @param string $searchedHash
     * @param string $query
     * @param int $page used in pagination
     * @param array $categories
     * @param array $authors
     * @return array standard formatted output
     */
    public function search(string $searchedHash, string $query, int $page, array $categories, array $authors): array;
}
