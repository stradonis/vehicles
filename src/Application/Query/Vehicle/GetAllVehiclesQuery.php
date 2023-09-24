<?php

declare(strict_types=1);

namespace App\Application\Query\Vehicle;

use App\Domain\Repository\VehicleRepositoryInterface;

readonly class GetAllVehiclesQuery
{
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepository
    ) {
    }

    public function getAll(): array
    {
        return $this->vehicleRepository->findAllArray();
    }
}

