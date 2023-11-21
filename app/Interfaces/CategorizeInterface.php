<?php

namespace App\Interfaces;

interface CategorizeInterface
{
    /**
     * get default categories to be used in api
     * @return array standard formatted output
     */
    public function getCategories(): array;
}
