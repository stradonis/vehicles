<?php

namespace App\UI\Http\Controller\Api;

use App\Application\Query\Vehicle\GetAllModelsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiModelController extends AbstractController
{
    #[Route('/models', name: 'models_get_all', methods: ['GET'])]
    public function getAll(GetAllModelsQuery $getAllModelsQuery): JsonResponse
    {
        return $this->json($getAllModelsQuery->getAll());
    }
}
