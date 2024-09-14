<?php

declare(strict_types=1);

namespace App\Application\Query\Vehicle;

use App\Domain\Repository\VehicleRepositoryInterface;
use App\UI\Http\Paginator\PaginatorInterface;

readonly class GetAllVehiclesQuery
{
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepository
    ) {
    }

    public function getAll(PaginatorInterface $paginator): array
    {
        return $this->vehicleRepository->findAllArray( $paginator);
    }

    public function getTotal(PaginatorInterface $paginator): int
    {
        return $this->vehicleRepository->getTotal( $paginator);
    }
}

