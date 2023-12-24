<?php

namespace App\Tests\Integration;

use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AppTest extends WebTestCase
{
    public function testRootEndpointShouldReturnOk(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        Assert::assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
