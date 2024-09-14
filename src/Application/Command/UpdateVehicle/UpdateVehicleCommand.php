<?php

declare(strict_types=1);

namespace App\Application\Command\UpdateVehicle;

readonly class UpdateVehicleCommand
{
    public function __construct(
        public string $uuid,
        public string $modelUuid,
        public string $registrationNumber,
    )
    {
    }
}

