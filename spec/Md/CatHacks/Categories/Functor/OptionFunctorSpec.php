<?php

namespace spec\Md\CatHacks\Categories\Functor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Md\CatHacks\Categories\Functor;
use BadMethodCallException;

class OptionFunctorSpec extends ObjectBehavior
{

    function it_is_a_functor()
    {
        $this->shouldHaveType(Functor::class);
    }

    function it_maps_None_to_None()
    {
        $this->map(None(), $x ==> 42)->shouldBeLike(None());
    }

    function it_maps_the_result_of_the_function_to_Some()
    {
        $this->map(Some(42), $x ==> $x + 1)->shouldBeLike(Some(43));
    }

    function it_does_not_map_through_a_different_kind()
    {
        $this->shouldThrow(BadMethodCallException::class)->duringMap(ImmList(1), $x ==> $x + 1);
    }
}
