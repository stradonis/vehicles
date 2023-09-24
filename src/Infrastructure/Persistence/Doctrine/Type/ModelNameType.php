<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\ValueObject\ModelName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class ModelNameType extends StringType
{
    public const NAME = 'model_name';

    /** @param ModelName $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->getName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ModelName
    {
        if (!$value) {
            return $value;
        }

        return new ModelName($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
