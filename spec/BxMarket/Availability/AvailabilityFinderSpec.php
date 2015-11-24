<?php

namespace spec\BxMarket\Availability;

use AppBundle\Entity\Booking;
use AppBundle\Entity\BookingRepository;
use AppBundle\Entity\Business;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Service;
use Doctrine\ORM\EntityRepository;
use League\Period\Period;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AvailabilityFinderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BxMarket\Availability\AvailabilityFinder');
    }

    function let(
        BookingRepository $bookingRepository,
        EntityRepository $employeeRepository,
        Employee $john,
        Employee $jane,
        Booking $booking1,
        Booking $booking2
    ) {
        $john->getId()->willReturn(243);
        $john->getWorkingHours(Argument::any())->willReturn([new \DateTimeImmutable("2042-01-01 09:00:00"), new \DateTimeImmutable("2042-01-01 17:00:00")]);
        $jane->getId()->willReturn(245);
        $jane->getWorkingHours(Argument::any())->willReturn([new \DateTimeImmutable("2042-01-01 09:00:00"), new \DateTimeImmutable("2042-01-01 10:00:00")]);
        $employeeRepository->findBy(Argument::any())->willReturn([$john, $jane]);
        $booking1->getStartDatetime()->willReturn(new \DateTimeImmutable("2042-01-01 11:25:00"));
        $booking1->getEndDatetime()->willReturn(new \DateTimeImmutable("2042-01-01 11:55:00"));
        $booking2->getStartDatetime()->willReturn(new \DateTimeImmutable("2042-01-01 10:15:00"));
        $booking2->getEndDatetime()->willReturn(new \DateTimeImmutable("2042-01-01 11:35:00"));
        $bookingRepository->findByDateAndEmployee(
                Argument::type('\DateTimeImmutable'),
                $john
            )->willReturn([$booking1]);
        $bookingRepository->findByDateAndEmployee(
                Argument::type('\DateTimeImmutable'),
                $jane
            )->willReturn([$booking2]);

        $this->beConstructedWith($bookingRepository, $employeeRepository);
    }

    function it_should_find_availabilities_by_date_and_service(Service $service, Business $business)
    {
        $business->getDisponibilityTimeSlot()->willReturn(15);
        $business->getWorkingHours(Argument::any())->willReturn([new \DateTimeImmutable("2042-01-01 09:00:00"), new \DateTimeImmutable("2042-01-01 17:00:00")]);
        $date = new \DateTimeImmutable("2042-01-01 00:00:01");
        $service->getId()->willReturn(42);
        $service->getBusiness()->willReturn($business);
        $service->getDuration()->willReturn(45);

        $res = $this->findByDateAndService($date, $service);
        $res->shouldHaveKey("10:00");
        $res->shouldHaveKey("10:15");
        $res->shouldHaveKey("10:30");
        $res->shouldNotHaveKey("10:45");
        $res->shouldHaveKey("12:15");
    }

    function it_should_find_the_real_start_time()
    {
        $startTime = new \DateTimeImmutable();
        $startTime = $startTime->setTime(8,45);
        $this->realStartTime($startTime)->shouldBeLike($startTime->setTime(8,45));
        $startTime = new \DateTimeImmutable();
        $startTime = $startTime->setTime(9,32);
        $this->realStartTime($startTime)->shouldBeLike($startTime->setTime(9,45));
        $startTime = new \DateTimeImmutable();
        $startTime = $startTime->setTime(10,55);
        $this->realStartTime($startTime)->shouldBeLike($startTime->setTime(11,00));
        $startTime = new \DateTimeImmutable();
        $startTime = $startTime->setTime(11,35);
        $this->realStartTime($startTime)->shouldBeLike($startTime->setTime(11,45));
        $startTime = new \DateTimeImmutable();
        $startTime = $startTime->setTime(8,00);
        $this->realStartTime($startTime)->shouldBeLike($startTime->setTime(8,00));
    }

    function it_should_calculate_the_time_slots(Service $service)
    {
        $service->getDuration()->willReturn(45);

        $startTime = new \DateTimeImmutable();
        $availablePeriod = new Period($startTime->setTime(8,45), $startTime->setTime(9,45));

        $this->setService($service);
        $this->calculateTimeSlots($availablePeriod)->shouldReturn(['08:45', '09:00']);
    }

}
