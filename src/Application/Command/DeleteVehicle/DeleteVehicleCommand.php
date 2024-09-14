<?php

declare(strict_types=1);

namespace App\Application\Command\DeleteVehicle;

readonly class DeleteVehicleCommand
{
    public function __construct(
        public string $uuid,
    )
    {
    }
}

