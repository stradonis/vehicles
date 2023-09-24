<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Service\RegistrationNumberValidatorInterface;

class RegistrationNumberValidatorMock implements RegistrationNumberValidatorInterface
{
    public function validate(string $registrationNumber): void
    {
    }
}

