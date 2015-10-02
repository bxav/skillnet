<?php

namespace AppBundle\Availability;

use AppBundle\Entity\Employee;
use AppBundle\Entity\Service;
use League\Period\Period;

class AvailabilityFinder
{

    protected $bookingRepository;

    protected $employeeRepository;

    protected $disponibilityTimeSlot = 15;

    private $service;

    private $date;

    private $startWorking;

    private $endWorking;

    private $timeSlots;

    public function __construct($bookingRepository, $employeeRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param Service $service
     */
    public function setService(Service $service)
    {
        $this->service = $service;
    }

    public function findByDateAndService(\DateTimeImmutable $date, Service $service)
    {
        $this->service = $service;
        $this->date = clone $date;

        $employees = $this->employeeRepository->findBy(['business' => $service->getBusiness()]);
        $this->disponibilityTimeSlot = $service->getBusiness()->getDisponibilityTimeSlot();

        $workingHours = $service->getBusiness()->getWorkingHours(clone $this->date);
        if(!$workingHours) {
            return [];
        }
        $this->startWorking = $workingHours[0];
        $this->endWorking = $workingHours[1];


        $this->timeSlots = [];
        foreach($employees as $employee) {
            $this->updateTimeSlotsByEmployee($employee);
        }
        ksort($this->timeSlots);
        return $this->timeSlots;
    }

    protected function updateTimeSlotsByEmployee($employee) {


        $bookings = $this->bookingRepository->findByDateAndEmployee($this->date, $employee);

        if (is_null($bookings)) {
            $bookings = [];
        }

        $startTime = $this->realStartTime(clone $this->startWorking);
        foreach($bookings as $booking) {
            if($this->endWorking->getTimestamp() < $booking->getEndDatetime()->getTimestamp()) {
                break;
            }

            if ($startTime->getTimestamp() <= $booking->getStartDatetime()->getTimestamp()) {
                $availablePeriod = new Period($startTime, $booking->getStartDatetime());
                $this->updateTimeSlotsInfos($this->calculateTimeSlots($availablePeriod), $employee);
            }

            if ($startTime->getTimestamp() <= $booking->getEndDatetime()->getTimestamp()) {
                $startTime = $this->realStartTime($booking->getEndDatetime());
            }
        }
        $availablePeriod = new Period($startTime, $this->endWorking);

        $this->updateTimeSlotsInfos($this->calculateTimeSlots($availablePeriod), $employee);

    }

    protected function updateTimeSlotsInfos($calculatedTimeSlots, Employee $employee) {
        foreach ($calculatedTimeSlots as $calculatedTimeSlot) {
            if (!isset($this->timeSlots[$calculatedTimeSlot]['date']) || !isset($this->timeSlots[$calculatedTimeSlot]['service'])) {
                $arrayHourAndMinute = explode(":", $calculatedTimeSlot);
                $this->timeSlots[$calculatedTimeSlot]['date'] = $this->date->setTime($arrayHourAndMinute[0], $arrayHourAndMinute[1]);
                $this->timeSlots[$calculatedTimeSlot]['service'] = $this->service->getId();
            }
            $this->timeSlots[$calculatedTimeSlot]['employees'][] = $employee->getId();
        }
    }

    public function realStartTime(\DateTimeInterface $dateTime)
    {
        $realMinute = $dateTime->format('i');
        $realTime = ceil($realMinute / $this->disponibilityTimeSlot) * $this->disponibilityTimeSlot;
        $realDateTime = clone $dateTime;
        $realDateTime = ($realTime >= 60) ? $realDateTime->add(new \DateInterval('PT'. floor($realTime / 60) .'H')) : $realDateTime;
        $realDateTime = $realDateTime->setTime($realDateTime->format('H'), $realTime % 60);

        return $realDateTime;
    }

    public function calculateTimeSlots(Period $availablePeriod)
    {
        $res = [];
        while (ceil($availablePeriod->getTimestampInterval() / 60) >= $this->service->getDuration()) {
            $res[] = $availablePeriod->getStartDate()->format("H:i");
            $availablePeriod = $availablePeriod->startingOn($availablePeriod->getStartDate()->add(new \DateInterval('PT'. $this->disponibilityTimeSlot .'M')));
        }

        return $res;
    }

}
