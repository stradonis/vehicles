<?php

declare(strict_types=1);

namespace App\Application\Command\UpdateVehicle;

use App\Application\Exception\ModelNotFoundException;
use App\Application\Exception\VehicleException;
use App\Application\Exception\VehicleNotFoundException;
use App\Domain\Entity\Vehicle\Vehicle;
use App\Domain\Repository\ModelRepositoryInterface;
use App\Domain\Repository\VehicleRepositoryInterface;
use App\Domain\Service\RegistrationNumberValidatorInterface;
use App\Domain\ValueObject\RegistrationNumber;
use Symfony\Component\HttpFoundation\Response;

readonly class UpdateVehicleCommandHandler
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository,
        private VehicleRepositoryInterface $vehicleRepository,
        private RegistrationNumberValidatorInterface $registrationNumberValidator
    ) {
    }

    /**
     * @throws ModelNotFoundException
     * @throws VehicleNotFoundException
     * @throws VehicleException
     */
    public function handle(UpdateVehicleCommand $command): string
    {
        $model = $this->modelRepository->findOneBy(['uuid' => $command->modelUuid])
            ?? throw new ModelNotFoundException(sprintf('Model by id {%d} not found', $command->modelUuid));

        $vehicle = $this->vehicleRepository->findOneBy(['uuid' => $command->uuid])
            ?? throw new VehicleNotFoundException(sprintf('Vehicle by id {%d} not found', $command->uuid));

        $findVehicle = $this->vehicleRepository->findOneByRegistrationNumberWithoutUuid(
            $command->registrationNumber,
            $command->uuid
        );

        if ($findVehicle instanceof Vehicle) {
            throw new VehicleException(
                'registration number already exists',
                Response::HTTP_BAD_REQUEST
            );
        }

        $registrationNumber = new RegistrationNumber($command->registrationNumber, $this->registrationNumberValidator);
        $vehicle->changerRegistrationNumber($registrationNumber);
        $vehicle->setModel($model);
        $vehicle->setModificationDate(new \DateTimeImmutable('now'));
        $this->vehicleRepository->save($vehicle);

        return $vehicle->getUuid();
    }
}

