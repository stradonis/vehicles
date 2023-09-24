<?php

namespace App\Tests\Factory\Brand;

use App\Domain\Entity\Brand\Brand;
use App\Infrastructure\Persistence\Doctrine\Repository\BrandRepository;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;
use App\Domain\ValueObject\BrandName;

/**
 * @extends ModelFactory<Brand>
 *
 * @method        Brand|Proxy                     create(array|callable $attributes = [])
 * @method static Brand|Proxy                     createOne(array $attributes = [])
 * @method static Brand|Proxy                     find(object|array|mixed $criteria)
 * @method static Brand|Proxy                     findOrCreate(array $attributes)
 * @method static Brand|Proxy                     first(string $sortedField = 'id')
 * @method static Brand|Proxy                     last(string $sortedField = 'id')
 * @method static Brand|Proxy                     random(array $attributes = [])
 * @method static Brand|Proxy                     randomOrCreate(array $attributes = [])
 * @method static BrandRepository|RepositoryProxy repository()
 * @method static Brand[]|Proxy[]                 all()
 * @method static Brand[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Brand[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Brand[]|Proxy[]                 findBy(array $attributes)
 * @method static Brand[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Brand[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class BrandFactory extends ModelFactory
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
            'brandName' => new BrandName('Peugeot'), // TODO add BRAND_NAME type manually
            'uuid' => Uuid::v4(), // TODO add UUID type manually
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Brand $brand): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Brand::class;
    }
}
