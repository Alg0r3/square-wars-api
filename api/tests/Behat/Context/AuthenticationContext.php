<?php

namespace App\Tests\Behat\Context;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use App\Tests\Factory\UserFactory;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AuthenticationContext extends ApiTestCase implements Context
{
    private ?string $password = null;
    private ?User $user = null;
    private ?ResponseInterface $response = null;

    /**
     * @Given a user with valid credentials
     */
    public function aUserWithValidCredentials(): void
    {
        $this->password = '$3CR3T';
        $this->user = UserFactory::new()
            ->withPassword($this->password)
            ->create()
            ->object();
    }

    /**
     * @Given a user with invalid credentials
     */
    public function aUserWithInvalidCredentials(): void
    {
        $this->password = 'R4ND0M';
        $this->user = UserFactory::createOne()->object();
    }

    /**
     * @When the user attempts to authenticate in the API
     *
     * @throws TransportExceptionInterface
     */
    public function theUserAttemptsToAuthenticateInTheAPI(): void
    {
        $client = self::createClient();
        $this->response = $client->request('POST', '/authentication', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'userIdentifier' => $this->user?->getUserIdentifier(),
                'password' => $this->password,
            ],
        ]);
    }

    /**
     * @Then the response status code should be :code
     *
     * @throws TransportExceptionInterface
     */
    public function theResponseStatusCodeShouldBe(int $expectedCode): void
    {
        $actualCode = $this->response?->getStatusCode();

        Assert::assertEquals($actualCode, $expectedCode);
    }

    /**
     * @Then a JWT token should be successfully returned
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function aJWTTokenShouldBeSuccessfullyReturned(): void
    {
        $content = $this->response?->getContent();

        if (null === $content) {
            throw new \RuntimeException('Response content is null.');
        }

        /** @var array<string, string> $decodedContent */
        $decodedContent = json_decode($content, true);

        Assert::assertArrayHasKey('token', $decodedContent);
    }
}
