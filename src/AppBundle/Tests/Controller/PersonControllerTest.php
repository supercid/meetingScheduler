<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/person/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/");

        $crawler = $client->request('GET', '/person/new');
        // $crawler = $client->click($crawler->selectLink('add')->link());
        $today = new \DateTime();
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form();
        $form['appbundle_person[name]']->setValue('Test');
        $form['appbundle_person[socialSecurityNumber]']->setValue('111');
        $form['appbundle_person[age]']->setValue(10);
        $form['appbundle_person[gender]']->select('Male');

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        $tomorrow = new \DateTime('tomorrow');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Save')->form();

        $form['appbundle_person[name]']->setValue('Foo');
        $form['appbundle_person[socialSecurityNumber]']->setValue('2222');
        $form['appbundle_person[age]']->setValue(10);
        $form['appbundle_person[gender]']->select('Female');


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
