<?php

namespace App\Utilities;

/**
 * This class is responsible for finding filter classes and implement them
 * as they are in scope of the model.
 *
 * You can create filter for models by creating a directory with the models name
 * then create classes for each filter.
 *
 * If you need to create class for other models rather than Article, make sure to
 * modify name space and insert it as a property in the model.
 */
class FilterBuilder
{
    protected $query;
    protected $filters;
    protected $classNamespace;

    public function __construct($classNamespace, $query, $filters)
    {
        $this->query = $query;
        $this->filters = $filters;
        $this->classNamespace = $classNamespace;
    }

    public function apply()
    {
        foreach ($this->filters as $name => $value) {
            $normailizedName = ucfirst($name);
            $class = $this->classNamespace . "\\{$normailizedName}";

            if (!class_exists($class)) {
                continue;
            }

            if (strlen($value)) {
                (new $class($this->query))->handle($value);
            } else {
                (new $class($this->query))->handle();
            }
        }

        return $this->query;
    }
}
