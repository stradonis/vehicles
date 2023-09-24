<?php

namespace App\Domain\ValueObject;

use App\Domain\Service\RegistrationNumberValidatorInterface;

readonly class RegistrationNumber
{
    private string $registrationNumber;

    public function __construct(string $registrationNumber, RegistrationNumberValidatorInterface $registrationNumberValidator)
    {
        $registrationNumberValidator->validate($registrationNumber);
        $this->registrationNumber = strtoupper($registrationNumber);
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }
}