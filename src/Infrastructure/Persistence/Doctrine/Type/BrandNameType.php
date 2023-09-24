<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\ValueObject\BrandName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class BrandNameType extends StringType
{
    public const NAME = 'brand_name';

    /** @param BrandName $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->getName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?BrandName
    {
        if (!$value) {
            return $value;
        }

        return new BrandName($value);
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

