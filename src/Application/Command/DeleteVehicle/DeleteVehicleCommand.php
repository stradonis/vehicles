<?php

declare(strict_types=1);

namespace App\Application\Command\DeleteVehicle;

use App\Domain\Entity\Vehicle\Vehicle;
readonly class DeleteVehicleCommand
{
    public function __construct(
        public string $uuid,
    )
    {
    }
}

