<?php

namespace AppBundle\Listener;

use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AncaRebeca\FullCalendarBundle\Model\Event;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use AppBundle\Entity\Meeting;
use Doctrine\ORM\EntityManager;

class LoadDataListener
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(CalendarEvent $calendarEvent)
    {
        $repository = $this->em->getRepository('AppBundle:Meeting');
        $meetings = $repository->findAll();

        /** @var Meeting $meeting */
        foreach ($meetings as $meeting) {
            $calendarEvent->addEvent(new Event($meeting->getName(), $meeting->getStartTime()));
        }
    }
}