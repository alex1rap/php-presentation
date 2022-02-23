<?php

namespace App\Tests\Controller;

use App\Service\Vehicle\VehicleService;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VehicleControllerTest extends WebTestCase
{

    /**
     * @var KernelBrowser|null
     */
    protected $client = null;

    public function testCarList(): void
    {
        $this->client = $this->client ?? static::createClient();
        $this->client->request(
            'POST',
            '/api/vehicles',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'type' => VehicleService::TYPE_CAR
            ])
        );
        $response = $this->client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('count', $responseData);
        $this->assertArrayHasKey('items', $responseData);
    }

    /**
     * @param array $vehicleData
     * @return array
     */
    protected function testVehicleCreation(array $vehicleData): array
    {
        $this->client = $this->client ?? static::createClient();
        $this->client->request(
            'POST',
            '/api/vehicle',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($vehicleData)
        );
        $response = $this->client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('status', $responseData);
        $this->assertArrayHasKey('vehicle', $responseData);
        $this->assertEquals('created', $responseData['status']);
        foreach ($vehicleData as $key => $value) {
            $this->assertEquals($value, $responseData['vehicle'][$key]);
        }
        return $responseData;
    }

    public function testCarCreation(): void
    {
        $carData = $this->testVehicleCreation([
            'model' => 'T13110 Sens',
            'brand' => 'Daewoo',
            'status' => VehicleService::STATUS_AVAILABLE,
            'price' => 65000,
            'type' => VehicleService::TYPE_CAR,
            'seats' => 5
        ]);
    }

    public function testTruckCreation(): void
    {
        $truckData = $this->testVehicleCreation([
            "model" => "R420",
            "brand" => "Scania",
            "type" => "truck",
            "status" => "sold",
            "price" => 6000000,
            "pollution_certificate" => "A"
        ]);
    }

    /**
     * @param array $vehicleData
     * @param int $id
     * @return array
     */
    protected function testVehicleUpdating(array $vehicleData, int $id): array
    {
        $this->client = $this->client ?? static::createClient();
        $this->client->request(
            'PATCH',
            '/api/vehicle/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($vehicleData)
        );
        $response = $this->client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('status', $responseData);
        $this->assertArrayHasKey('vehicle', $responseData);
        $this->assertEquals('updated', $responseData['status']);
        foreach ($vehicleData as $key => $value) {
            $this->assertEquals($value, $responseData['vehicle'][$key]);
        }
        return $responseData;
    }

    public function testCarCreationAndUpdating(): void
    {
        $carData = $this->testVehicleCreation([
            'model' => 'T13110 Sens',
            'brand' => 'Daewoo',
            'status' => VehicleService::STATUS_AVAILABLE,
            'price' => 65000,
            'type' => VehicleService::TYPE_CAR,
            'seats' => 5
        ])['vehicle'];
        $carData['price'] = 60000;
        $this->testVehicleUpdating($carData, $carData['id']);
    }

    public function testTruckCreationAndUpdating(): void
    {
        $truckData = $this->testVehicleCreation([
            "model" => "R420",
            "brand" => "Scania",
            "type" => "truck",
            "status" => "sold",
            "price" => 6000000,
            "pollution_certificate" => "A"
        ])['vehicle'];
        $truckData['price'] = 5750000;
        $truckData['pollution_certificate'] = 'B';
        $this->testVehicleUpdating($truckData, $truckData['id']);
    }

}
