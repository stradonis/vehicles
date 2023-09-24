<?php

namespace tests\UI\Http;

use App\Tests\BaseWebTestCase;
use App\Tests\Factory\Vehicle\VehicleFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use Symfony\Component\HttpFoundation\Request;

class ApiVehicleTest extends BaseWebTestCase
{
    use Factories, ResetDatabase;
    private const API_URL = '/api/vehicles';

    public function testVehicleList(): void
    {
        VehicleFactory::createOne();
        $this->client->request(Request::METHOD_GET, self::API_URL);
        $response = $this->client->getResponse();
        $content = json_decode($response->getContent());
        $data = $content[0];

        self::assertEquals(200, $response->getStatusCode());
        self::assertCount(1, $content);
        self::assertObjectHasProperty('registration_number', $data);
        self::assertObjectHasProperty('creation_date', $data);
        self::assertObjectHasProperty('modification_date', $data);
        self::assertObjectHasProperty('model', $data);
        self::assertObjectHasProperty('brand', $data);
        self::assertObjectHasProperty('model_id', $data);
        self::assertObjectHasProperty('id', $data);
    }
}