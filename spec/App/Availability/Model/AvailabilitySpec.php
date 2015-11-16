<?php

namespace spec\App\Availability\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AvailabilitySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Availability\Model\Availability');
    }
}
