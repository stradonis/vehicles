<?php

namespace App\UI\Http\Controller\Api;

use App\Application\Command\CreateVehicle\CreateVehicleCommand;
use App\Application\Command\CreateVehicle\CreateVehicleCommandHandler;
use App\Application\Command\DeleteVehicle\DeleteVehicleCommand;
use App\Application\Command\DeleteVehicle\DeleteVehicleCommandHandler;
use App\Application\Command\Notification\NotificationCommand;
use App\Application\Command\UpdateVehicle\UpdateVehicleCommand;
use App\Application\Command\UpdateVehicle\UpdateVehicleCommandHandler;
use App\Application\Query\Vehicle\GetAllVehiclesQuery;
use App\UI\Http\Paginator\Paginator;
use App\UI\Http\Request\Vehicle\CreateVehicleRequest;
use App\UI\Http\Request\Vehicle\UpdateVehicleRequest;
use App\UI\Http\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;

class ApiVehicleController extends AbstractController
{
    public function __construct(
        private readonly CreateVehicleCommandHandler $createVehicleCommandHandler,
        private readonly UpdateVehicleCommandHandler $updateVehicleCommandHandler,
        private readonly DeleteVehicleCommandHandler $deleteVehicleCommandHandler,
        private readonly ApiResponse $apiResponse,
        private readonly MessageBusInterface $messageBus
    )
    {
    }

    #[Route('/vehicles', name: 'vehicles_get_all', methods: ['GET'])]
    public function getAll(GetAllVehiclesQuery $getAllVehiclesQuery, Request $request): JsonResponse
    {
        $paginator = new Paginator($request->query->get('page'));

        return $this->apiResponse
            ->withData($getAllVehiclesQuery->getAll($paginator))
            ->withTotalCount($getAllVehiclesQuery->getTotal($paginator))
            ->response();
    }

    #[Route('/vehicles', name: 'vehicles_create', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateVehicleRequest $request): JsonResponse
    {
        $this->createVehicleCommandHandler->handle(
            new CreateVehicleCommand(
                $request->model,
                $request->registrationNumber,
                $uuid = Uuid::v4()
            )
        );
        $notification = $this->getParameter('notification');

        if (!empty($notification['email_from']) && !empty($notification['email_to'])) {
            $this->messageBus->dispatch(new NotificationCommand(
                    $notification['email_from'],
                    $notification['email_to'],
                    'vehicle was create',
                    'vehicle uuid = ' . $uuid
                )
            );
        }

        return $this->apiResponse
            ->withUuid($uuid)
            ->response();
    }

    #[Route('/vehicles/{uuid}', name: 'vehicles_edit', methods: ['PATCH'])]
    public function update(#[MapRequestPayload] UpdateVehicleRequest $request, string $uuid): JsonResponse
    {
        $this->updateVehicleCommandHandler->handle(
            new UpdateVehicleCommand(
                $uuid,
                $request->model,
                $request->registrationNumber
            )
        );

        return $this->apiResponse
            ->withUuid($uuid)
            ->response();
    }

    #[Route('/vehicles/{uuid}', name: 'vehicles_delete', methods: ['DELETE'])]
    public function delete(string $uuid): JsonResponse
    {
        $this->deleteVehicleCommandHandler->handle(
            new DeleteVehicleCommand($uuid)
        );

        return $this->apiResponse
            ->withUuid($uuid)
            ->response();
    }
}
