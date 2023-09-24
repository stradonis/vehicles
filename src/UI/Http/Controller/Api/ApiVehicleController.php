<?php

namespace App\UI\Http\Controller\Api;

use App\Application\Command\CreateVehicle\CreateVehicleCommand;
use App\Application\Command\CreateVehicle\CreateVehicleCommandHandler;
use App\Application\Command\DeleteVehicle\DeleteVehicleCommand;
use App\Application\Command\DeleteVehicle\DeleteVehicleCommandHandler;
use App\Application\Command\UpdateVehicle\UpdateVehicleCommand;
use App\Application\Command\UpdateVehicle\UpdateVehicleCommandHandler;
use App\Application\Exception\ModelNotFoundException;
use App\Application\Exception\VehicleException;
use App\Application\Exception\VehicleNotFoundException;
use App\Application\Query\Vehicle\GetAllVehiclesQuery;
use App\UI\Http\Request\Vehicle\CreateVehicleRequest;
use App\UI\Http\Request\Vehicle\UpdateVehicleRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class ApiVehicleController extends AbstractController
{
    public function __construct(
        private readonly CreateVehicleCommandHandler $createVehicleCommandHandler,
        private readonly UpdateVehicleCommandHandler $updateVehicleCommandHandler,
        private readonly DeleteVehicleCommandHandler $deleteVehicleCommandHandler
    ) {
    }

    #[Route('/vehicles', name: 'vehicles_get_all', methods: ['GET'])]
    public function getAll(GetAllVehiclesQuery $getAllVehiclesQuery): JsonResponse
    {
        return $this->json($getAllVehiclesQuery->getAll());
    }

    #[Route('/vehicles', name: 'vehicles_create', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateVehicleRequest $request): JsonResponse
    {
        try {
            $this->createVehicleCommandHandler->handle(
                new CreateVehicleCommand(
                    $request->model,
                    $request->registrationNumber,
                    $uuid = Uuid::v4()
                )
            );
        } catch (VehicleException $exception) {
            return $this->json(['detail' => $exception->getMessage()], $exception->getCode());
        }

        return $this->json(["id" => $uuid]);
    }

    #[Route('/vehicles/{uuid}', name: 'vehicles_edit', methods: ['PATCH'])]
    public function update(#[MapRequestPayload] UpdateVehicleRequest $request, string $uuid): JsonResponse
    {
        try {
            $this->updateVehicleCommandHandler->handle(
                new UpdateVehicleCommand(
                    $uuid,
                    $request->model,
                    $request->registrationNumber
                )
            );
        } catch (VehicleException $exception) {
            return $this->json(['detail' => $exception->getMessage()], $exception->getCode());
        }

        return $this->json(["id" => $uuid]);
    }

    #[Route('/vehicles/{uuid}', name: 'vehicles_delete', methods: ['DELETE'])]
    public function delete(string $uuid): JsonResponse
    {
        try {
            $this->deleteVehicleCommandHandler->handle(
                new DeleteVehicleCommand($uuid)
            );
        } catch (VehicleException $exception) {
            return $this->json($exception->getMessage(), $exception->getCode());
        }

        return $this->json(["id" => $uuid]);
    }
}
