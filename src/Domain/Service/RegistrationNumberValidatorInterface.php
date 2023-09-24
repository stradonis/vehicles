<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface RegistrationNumberValidatorInterface
{
    public function validate(string $registrationNumber): void;
}
