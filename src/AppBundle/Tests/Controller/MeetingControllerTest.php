<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeetingControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/meeting/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /meeting/");

        $crawler = $client->request('GET', '/meeting/new');
        // $crawler = $client->click($crawler->selectLink('add')->link());
        $today = new \DateTime();
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'appbundle_meeting[name]'  => 'Test',
            'appbundle_meeting[startTime]'  => $today->format('Y-m-d H:i:s'),
            'appbundle_meeting[endTime]'  => $today->format('Y-m-d H:i:s'),
            'appbundle_meeting[location]'  => 'TestLocation',
            'appbundle_meeting[description]'  => 'TestDescription',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        $tomorrow = new \DateTime('tomorrow');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Save')->form(array(
            'appbundle_meeting[name]'  => 'Foo',
            'appbundle_meeting[startTime]'  => $tomorrow->format('Y-m-d H:i:s'),
            'appbundle_meeting[endTime]'  => $tomorrow->format('Y-m-d H:i:s'),
            'appbundle_meeting[location]'  => 'FooLocation',
            'appbundle_meeting[description]'  => 'FooDescription',

        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(
            0,
            $crawler->filter('td:contains("Foo")')->count(),
            'Missing element td:contains("Foo")'
        );

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();
    }


}
