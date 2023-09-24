<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\ValueObject\RegistrationNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class RegistrationNumberType extends StringType
{
    public const NAME = 'registration_number';

    /** @param RegistrationNumber $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->getRegistrationNumber();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?RegistrationNumber
    {
        if (!$value) {
            return $value;
        }

        return new RegistrationNumber($value, new RegistrationNumberValidatorMock());
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

