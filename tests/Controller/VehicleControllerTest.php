<?php

namespace App\Tests\Controller;


use App\Service\Vehicle\VehicleService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VehicleControllerTest extends WebTestCase
{

    public function testCarList(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/vehicles',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'type' => VehicleService::TYPE_CAR
            ])
        );
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('count', $responseData);
        $this->assertArrayHasKey('items', $responseData);
    }

}
