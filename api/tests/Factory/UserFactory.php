<?php

namespace App\Tests\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<User>
 *
 * @method        User|Proxy                     create(array|callable $attributes = [])
 * @method static User|Proxy                     createOne(array $attributes = [])
 * @method static User|Proxy                     find(object|array|mixed $criteria)
 * @method static User|Proxy                     findOrCreate(array $attributes)
 * @method static User|Proxy                     first(string $sortedField = 'id')
 * @method static User|Proxy                     last(string $sortedField = 'id')
 * @method static User|Proxy                     random(array $attributes = [])
 * @method static User|Proxy                     randomOrCreate(array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method static User[]|Proxy[]                 all()
 * @method static User[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static User[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static User[]|Proxy[]                 findBy(array $attributes)
 * @method static User[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static User[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<User> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<User> createOne(array $attributes = [])
 * @phpstan-method static Proxy<User> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<User> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<User> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<User> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<User> random(array $attributes = [])
 * @phpstan-method static Proxy<User> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<User> repository()
 */
final class UserFactory extends ModelFactory
{
    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory
    ) {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'password' => $this->getDefaultPassword(),
            'roles' => ['ROLE_USER'],
            'userIdentifier' => $this->getDefaultUserIdentifier(),
        ];
    }

    protected function initialize(): self
    {
        return $this;
    }

    protected static function getClass(): string
    {
        return User::class;
    }

    public function withUserIdentifier(string $userIdentifier): self
    {
        return $this->addState(['userIdentifier' => $userIdentifier]);
    }

    public function withPassword(string $password): self
    {
        $hasher = $this->passwordHasherFactory->getPasswordHasher(User::class);

        return $this->addState(['password' => $hasher->hash($password)]);
    }

    private function getDefaultPassword(): string
    {
        $plainPassword = self::faker()->password();
        $hasher = $this->passwordHasherFactory->getPasswordHasher(User::class);

        return $hasher->hash($plainPassword);
    }

    private function getDefaultUserIdentifier(): string
    {
        $randomNumber = self::faker()->numberBetween(100, 999);
        $randomDomainWord = self::faker()->domainWord();

        return "$randomDomainWord$randomNumber.alg0r3";
    }
}
