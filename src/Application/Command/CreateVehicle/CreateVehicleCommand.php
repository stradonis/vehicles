<?php

declare(strict_types=1);

namespace App\Application\Command\CreateVehicle;

class CreateVehicleCommand
{
    public function __construct(
        public string $modelUuid,
        public string $registrationNumber,
        public string $uuid
    )
    {
    }
}

