<?php

namespace App\Tests\Factory\Vehicle;

use App\Domain\Entity\Vehicle\Vehicle;
use App\Infrastructure\Persistence\Doctrine\Repository\VehiclesRepository;
use App\Tests\Factory\Model\ModelFactory;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\ModelFactory as Factory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;
use App\Domain\ValueObject\RegistrationNumber;
use App\Infrastructure\Persistence\Doctrine\Type\RegistrationNumberValidatorMock;

/**
 * @extends ModelFactory<Vehicle>
 *
 * @method        Vehicle|Proxy                      create(array|callable $attributes = [])
 * @method static Vehicle|Proxy                      createOne(array $attributes = [])
 * @method static Vehicle|Proxy                      find(object|array|mixed $criteria)
 * @method static Vehicle|Proxy                      findOrCreate(array $attributes)
 * @method static Vehicle|Proxy                      first(string $sortedField = 'id')
 * @method static Vehicle|Proxy                      last(string $sortedField = 'id')
 * @method static Vehicle|Proxy                      random(array $attributes = [])
 * @method static Vehicle|Proxy                      randomOrCreate(array $attributes = [])
 * @method static VehiclesRepository|RepositoryProxy repository()
 * @method static Vehicle[]|Proxy[]                  all()
 * @method static Vehicle[]|Proxy[]                  createMany(int $number, array|callable $attributes = [])
 * @method static Vehicle[]|Proxy[]                  createSequence(iterable|callable $sequence)
 * @method static Vehicle[]|Proxy[]                  findBy(array $attributes)
 * @method static Vehicle[]|Proxy[]                  randomRange(int $min, int $max, array $attributes = [])
 * @method static Vehicle[]|Proxy[]                  randomSet(int $number, array $attributes = [])
 */
final class VehicleFactory extends Factory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'creationDate' => self::faker()->dateTime(),
            'model' => ModelFactory::new(),
            'modificationDate' => self::faker()->dateTime(),
            'registrationNumber' => new RegistrationNumber(
                'PO12345',
                new RegistrationNumberValidatorMock
            ), // TODO add REGISTRATION_NUMBER type manually
            'uuid' => Uuid::v4(), // TODO add UUID type manually
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Vehicle $vehicle): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Vehicle::class;
    }
}
