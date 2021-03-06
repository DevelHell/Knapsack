<?php

namespace spec\Knapsack;

use Knapsack\Collection;
use Knapsack\FilteredCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin FilteredCollection
 */
class FilteredCollectionSpec extends ObjectBehavior
{
    function let()
    {
        $input = [5, 1, 3, 4];
        $filter = function ($item) {
            return $item > 3;
        };
        $this->beConstructedWith($input, $filter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilteredCollection::class);
        $this->shouldHaveType(Collection::class);
    }

    function it_filters()
    {
        $this->toArray()->shouldReturn([0 => 5, 3 => 4]);
    }

    function it_can_filter_with_keys()
    {
        $input = [5, 1, 3, 4];
        $filter = function ($key, $item) {
            return $key > 2;
        };
        $this->beConstructedWith($input, $filter);

        $this->toArray()->shouldReturn([3 => 4]);
    }
}
