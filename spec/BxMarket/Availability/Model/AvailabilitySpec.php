<?php

namespace spec\BxMarket\Availability\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AvailabilitySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BxMarket\Availability\Model\Availability');
    }
}
