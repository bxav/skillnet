<?php

namespace spec\AppBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmployeeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('AppBundle\Entity\Employee');
    }

    function it_should_give_the_working_hours_by_datime()
    {

        $this->setWorkingHoursByDay('monday', ['08:00', '17:00']);
        $this->setWorkingHoursByDay('tuesday', ['10:00', '13:00']);
        $this->setWorkingHoursByDay('wednesday', ['09:00', '19:00']);
        $this->setWorkingHoursByDay('thursday', ['06:15', '16:00']);
        $this->setWorkingHoursByDay('friday', ['12:00', '13:00']);

        //2042-01-01 is a wednesday
        $date1 = new \DateTimeImmutable("2042-01-01");
        $date2 = new \DateTimeImmutable("2042-01-02");
        $this->getWorkingHours($date1)->shouldBeLike([new \DateTimeImmutable("2042-01-01 09:00"), new \DateTimeImmutable("2042-01-01 19:00")]);
        $this->getWorkingHours($date2)->shouldBeLike([new \DateTimeImmutable("2042-01-02 06:15"), new \DateTimeImmutable("2042-01-02 16:00")]);
    }
}
