<?php

namespace Knapsack;

use ReflectionFunction;

class SortedCollection extends Collection
{
    /**
     * @var callable
     */
    private $sortCallback;

    private $isSorting = FALSE;

    /**
     * @param array|\Traversable $input
     * @param callable $sortCallback
     */
    public function __construct($input, callable $sortCallback)
    {
        parent::__construct($input);
        $this->sortCallback = $sortCallback;
    }

    public function rewind()
    {
        if (!$this->isSorting) {
            $this->isSorting = TRUE;
            $this->executeSort($this->sortCallback);
            $this->isSorting = FALSE;
        }
        parent::rewind();
    }

    private function executeSort($sortCallback)
    {
        $isUsingKeys = (new ReflectionFunction($sortCallback))->getNumberOfParameters() == 4;
        $mapped = $this->map(function ($k, $v) {
            return [$k, $v];
        })->resetKeys()->toArray();

        if ($isUsingKeys) {
            uasort($mapped,
                function ($a, $b) use ($sortCallback) {
                    return $sortCallback($a[0], $a[1], $b[0], $b[1]);
                });
        } else {
            uasort($mapped,
                function ($a, $b) use ($sortCallback) {
                    return $sortCallback($a[1], $b[1]);
                });
        }

        $this->input = (new Collection($mapped))->map(function ($v) {
            yield $v[0];
            yield $v[1];
        });
    }
}