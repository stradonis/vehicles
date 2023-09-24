<?php

declare(strict_types=1);

namespace App\Application\Command\DeleteVehicle;

use App\Application\Exception\ModelNotFoundException;
use App\Application\Exception\VehicleNotFoundException;
use App\Domain\Repository\VehicleRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

readonly class DeleteVehicleCommandHandler
{
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepository
    ) {
    }

    /**
     * @throws ModelNotFoundException
     * @throws VehicleNotFoundException
     */
    public function handle(DeleteVehicleCommand $command): string
    {
        $vehicle = $this->vehicleRepository->findOneBy(['uuid' => $command->uuid])
                ?? throw new VehicleNotFoundException(
                    sprintf('Vehicle by id {%d} not found', $command->uuid),
                    Response::HTTP_NOT_FOUND
                );

        $this->vehicleRepository->remove($vehicle);

        return $vehicle->getUuid();
    }
}

