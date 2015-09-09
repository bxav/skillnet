<?php

namespace AppBundle\Availability;

use AppBundle\Entity\Service;
use League\Period\Period;

class AvailabilityFinder
{

    protected $bookingRepository;

    protected $employeeRepository;

    protected $timeSlot = 15;

    public function __construct($bookingRepository, $employeeRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function findByDateAndService(\DateTimeImmutable $date, Service $service)
    {
        $dateForWorkingHours = clone $date;
        $startWorking = $dateForWorkingHours->setTime(8, 00);
        $endWorking = $dateForWorkingHours->setTime(19, 00);

        $employees = $this->employeeRepository->findBy(['business' => $service->getBusiness()]);

        $timeSlots = [];
        foreach($employees as $employee) {
            $bookings = $this->bookingRepository->findByDateAndEmployee($date, $employee);

            $startTime = clone $startWorking;
            if (!is_null($bookings)) {
                foreach($bookings as $booking) {
                    $availablePeriod = new Period($this->realStartTime($startTime), $booking->getStartDatetime());

                    $timeSlots = $this->reverseKey($timeSlots, $this->calculateTimeSlots($availablePeriod, $service->getDuration()), $employee);

                    $startTime = $booking->getEndDatetime();
                }
                $availablePeriod = new Period($this->realStartTime($startTime), $endWorking);

                $timeSlots = $this->reverseKey($timeSlots, $this->calculateTimeSlots($availablePeriod, $service->getDuration()), $employee);
            } else {
                $availablePeriod = new Period($startWorking, $endWorking);
                $timeSlots = $this->reverseKey($timeSlots, $this->calculateTimeSlots($availablePeriod, $service->getDuration()), $employee);
            }


        }
        ksort($timeSlots);
        return $timeSlots;
    }

    protected function reverseKey($timeSlots, $calculatedTimeSlots, $employee) {
        foreach ($calculatedTimeSlots as $calculatedTimeSlot) {
            $timeSlots[$calculatedTimeSlot][] = ['employeeId' => $employee->getId()];
        }
        return $timeSlots;
    }

    public function realStartTime(\DateTimeInterface $dateTime)
    {
        $realMinute = $dateTime->format('i');
        $realTime = ceil($realMinute / $this->timeSlot) * $this->timeSlot;
        $realDateTime = clone $dateTime;
        $realDateTime = ($realTime >= 60) ? $realDateTime->add(new \DateInterval('PT'. floor($realTime / 60) .'H')) : $realDateTime;
        $realDateTime = $realDateTime->setTime($realDateTime->format('H'), $realTime % 60);

        return $realDateTime;
    }

    public function calculateTimeSlots(Period $availablePeriod, $serviceDuration)
    {
        $res = [];
        while (ceil($availablePeriod->getTimestampInterval() / 60) >= $serviceDuration) {
            $res[] = $availablePeriod->getStartDate()->format("H:i");
            $availablePeriod = $availablePeriod->startingOn($availablePeriod->getStartDate()->add(new \DateInterval('PT'. $this->timeSlot .'M')));
        }

        return $res;
    }

}
