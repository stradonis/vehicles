<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Exception\VehicleException;
use App\Domain\Service\RegistrationNumberValidatorInterface;
use Symfony\Component\HttpFoundation\Response;

readonly class RegistrationNumberValidator implements RegistrationNumberValidatorInterface
{
    /**
     * @throws VehicleException
     */
    public function validate(string $registrationNumber): void
    {
        if (!preg_match("/^([A-Za-z]|[0-9])+$/", $registrationNumber)) {
            throw new VehicleException(
                "the registration number should consist only of numbers and letters",
                Response::HTTP_BAD_REQUEST
            );
        }

        if (strlen($registrationNumber) > 9 || strlen($registrationNumber) < 4) {
            throw new VehicleException(
                "the registration number may consist of 4 to 9 characters",
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}

