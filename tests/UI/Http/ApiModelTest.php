<?php

namespace tests\UI\Http;

use App\Tests\BaseWebTestCase;
use App\Tests\Factory\Model\ModelFactory;
use Symfony\Component\HttpFoundation\Request;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ApiModelTest extends BaseWebTestCase
{
    use Factories, ResetDatabase;
    const API_URL = 'api/models';

    public function testModelList(): void
    {
        ModelFactory::createOne();
        $this->client->request(Request::METHOD_GET, self::API_URL);
        $response = $this->client->getResponse();
        $content = json_decode($response->getContent());
        $data = $content[0];

        self::assertEquals(200, $response->getStatusCode());
        self::assertCount(1, $content);
        self::assertObjectHasProperty('id', $data);
        self::assertObjectHasProperty('name', $data);
    }
}