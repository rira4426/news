<?php

namespace App\Interfaces;

interface NewsProviderInterface
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
    public function search(string $searchedHash, array $providers, string $query, int $page, array $categories, array $authors): array;
}
