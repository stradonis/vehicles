<?php

namespace App\Tests\Factory\Model;

use App\Domain\Entity\Model\Model;
use App\Infrastructure\Persistence\Doctrine\Repository\ModelRepository;
use App\Tests\Factory\Brand\BrandFactory;
use Zenstruck\Foundry\ModelFactory as Factory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;
use App\Domain\ValueObject\ModelName;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ModelFactory<Model>
 *
 * @method        Model|Proxy                     create(array|callable $attributes = [])
 * @method static Model|Proxy                     createOne(array $attributes = [])
 * @method static Model|Proxy                     find(object|array|mixed $criteria)
 * @method static Model|Proxy                     findOrCreate(array $attributes)
 * @method static Model|Proxy                     first(string $sortedField = 'id')
 * @method static Model|Proxy                     last(string $sortedField = 'id')
 * @method static Model|Proxy                     random(array $attributes = [])
 * @method static Model|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ModelRepository|RepositoryProxy repository()
 * @method static Model[]|Proxy[]                 all()
 * @method static Model[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Model[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Model[]|Proxy[]                 findBy(array $attributes)
 * @method static Model[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Model[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ModelFactory extends Factory
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
            'brand' => BrandFactory::new(),
            'modelName' => new ModelName('308'),
            'uuid' => Uuid::v4(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Model $model): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Model::class;
    }
}
