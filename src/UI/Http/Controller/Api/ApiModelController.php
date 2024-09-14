<?php

namespace App\UI\Http\Controller\Api;

use App\Application\Query\Vehicle\GetAllModelsQuery;
use App\UI\Http\Paginator\Paginator;
use App\UI\Http\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiModelController extends AbstractController
{
    #[Route('/models', name: 'models_get_all', methods: ['GET'])]
    public function getAll(
        GetAllModelsQuery $getAllModelsQuery,
        Request $request,
        ApiResponse $apiResponse
    ): JsonResponse {
        $paginator = new Paginator($request->query->get('page'));

        return $apiResponse
            ->withData($getAllModelsQuery->getAllModelWithBrand($paginator))
            ->withTotalCount($getAllModelsQuery->getTotalModelWithBrand($paginator))
            ->response();
    }
}
