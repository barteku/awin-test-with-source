<?php

namespace Awin\Tests\Tools\CoffeeBreak\Controller;

use App\DataFixtures\AppFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CoffeeBreakPreferenceControllerTest extends WebTestCase
{

    use FixturesTrait;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([
            AppFixtures::class
        ]);
    }


    public function testTodayAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/today');

        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("bart would like a sandwich")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("bart would like a coffee")')->count()
        );


        $crawler = $client->request('GET', '/today', ['team' => 'support']);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("john would like a toast")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("john would like a tea")')->count()
        );


        $client = static::createClient();
        $client->request('GET', '/today.json');
        $response = $client->getResponse();
        $this->assertSame('application/json', $response->headers->get('Content-Type'));


        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('preferences', $responseData);
        $this->assertCount(2, $responseData['preferences']);



        $client = static::createClient();
        $client->request('GET', '/today.json');
        $response = $client->getResponse();
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
    }
}
