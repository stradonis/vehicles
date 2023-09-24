<?php

declare(strict_types=1);

namespace App\Application\Command\CreateVehicle;

use App\Application\Exception\ModelNotFoundException;
use App\Application\Exception\VehicleException;
use App\Domain\Entity\Vehicle\Vehicle;
use App\Domain\Repository\ModelRepositoryInterface;
use App\Domain\Repository\VehicleRepositoryInterface;
use App\Domain\Service\RegistrationNumberValidatorInterface;
use App\Domain\ValueObject\RegistrationNumber;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

readonly class CreateVehicleCommandHandler
{
    public function __construct(
        private ModelRepositoryInterface             $modelRepository,
        private VehicleRepositoryInterface           $vehicleRepository,
        private RegistrationNumberValidatorInterface $registrationNumberValidator
    ) {
    }

    /**
     * @throws ModelNotFoundException
     * @throws VehicleException
     * */
    public function handle(CreateVehicleCommand $command): string
    {
        $model = $this->modelRepository->findOneBy(['uuid' => $command->modelUuid])
                ?? throw new ModelNotFoundException(sprintf('Model by id {%d} not found', $command->modelUuid));

        $findVehicle = $this->vehicleRepository->findOneByRegistrationNumber($command->registrationNumber);

        if ($findVehicle instanceof Vehicle) {
            throw new VehicleException(
                'registration number already exists',
                Response::HTTP_BAD_REQUEST
            );
        }

        $registrationNumber = new RegistrationNumber($command->registrationNumber, $this->registrationNumberValidator);

        // exception model exists
        $vehicle = new Vehicle($registrationNumber);
        $vehicle->setModel($model);
        $vehicle->setUuid($command->uuid);
        $vehicle->setCreationDate(new \DateTimeImmutable('now'));

        $this->vehicleRepository->save($vehicle);

        return $command->uuid;
    }
}

