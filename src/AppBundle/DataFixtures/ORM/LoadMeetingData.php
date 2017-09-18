<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Meeting;
use AppBundle\Entity\Person;

class LoadMeetingData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $meeting = new Meeting();
        $person = new Person();

        $person->setName('John Wick');
        $person->setSocialSecurityNumber(0100101);
        $person->setAge(30);
        $person->setGender('Male');

        $meeting->setName('Math class');

        $today = new \DateTime();

        $meeting->setStartTime($today);
        $meeting->setEndTime($today);
        $meeting->setLocation("Fortaleza");
        $meeting->setDescription("The class will take place in room 39B, second floor.");
        $meeting->addParticipant($person);
        $manager->persist($meeting);

        $meeting = new Meeting();
        $person = new Person();

        $person->setName('Madonna');
        $person->setSocialSecurityNumber(11111);
        $person->setAge(90);
        $person->setGender('Female');

        $meeting->setName('Pick up dry cleaning');

        $tomorrow = new \DateTime('tomorrow');

        $meeting->setStartTime($tomorrow);
        $meeting->setEndTime($tomorrow);
        $meeting->setLocation("Av. Dom Luis");
        $meeting->setDescription("Pick up the dry cleaning, 3 suits and a pair of pants.");
        $meeting->addParticipant($person);
        $manager->persist($meeting);

        $manager->flush();
    }
}
