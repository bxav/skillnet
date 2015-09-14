<?php

namespace AppBundle\Availability;

use AppBundle\Entity\Employee;
use AppBundle\Entity\Service;
use League\Period\Period;

class AvailabilityFinder
{

    protected $bookingRepository;

    protected $employeeRepository;

    protected $timeSlot = 15;

    private $service;

    private $date;

    public function __construct($bookingRepository, $employeeRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function findByDateAndService(\DateTimeImmutable $date, Service $service)
    {
        $this->service = $service;
        $this->date = clone $date;

        $dateForWorkingHours = clone $date;

        $employees = $this->employeeRepository->findBy(['business' => $service->getBusiness()]);
        $this->timeSlot = $service->getBusiness()->getdisponibilityTimeSlot();

        $timeSlots = [];
        foreach($employees as $employee) {
            $workingHours = $employee->getWorkingHours($dateForWorkingHours);
            if (is_null($workingHours)) {
                continue;
            }
            $startWorking = $workingHours[0];
            $endWorking = $workingHours[1];

            $bookings = $this->bookingRepository->findByDateAndEmployee($date, $employee);

            $startTime = clone $startWorking;
            if (!is_null($bookings)) {
                foreach($bookings as $booking) {
                    $startTime = $this->realStartTime($startTime);
                    if($endWorking->getTimestamp() < $booking->getEndDatetime()->getTimestamp()) {
                        break;
                    } elseif ($startTime->getTimestamp() <= $booking->getStartDatetime()->getTimestamp()) {
                        $availablePeriod = new Period($startTime, $booking->getStartDatetime());
                        $timeSlots = $this->reverseKey($timeSlots, $this->calculateTimeSlots($availablePeriod, $service->getDuration()), $employee);
                    }

                    if ($startTime->getTimestamp() <= $booking->getEndDatetime()->getTimestamp()) {
                        $startTime = $booking->getEndDatetime();
                    }
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

    protected function reverseKey($timeSlots, $calculatedTimeSlots, Employee $employee) {
        foreach ($calculatedTimeSlots as $calculatedTimeSlot) {
            if (!isset($timeSlots[$calculatedTimeSlot]['date'])) {
                $arrayHourAndMinute = explode(":", $calculatedTimeSlot);
                $timeSlots[$calculatedTimeSlot]['date'] = $this->date->setTime($arrayHourAndMinute[0], $arrayHourAndMinute[1]);
            }
            $timeSlots[$calculatedTimeSlot]['service'] = $this->service->getId();
            $timeSlots[$calculatedTimeSlot]['employees'][] = $employee->getId();
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
