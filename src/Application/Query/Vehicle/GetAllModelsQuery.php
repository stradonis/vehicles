<?php

declare(strict_types=1);

namespace App\Application\Query\Vehicle;

use App\Domain\Repository\ModelRepositoryInterface;
use App\UI\Http\Paginator\PaginatorInterface;

readonly class GetAllModelsQuery
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository
    ) {
    }

    public function getAllModelWithBrand(PaginatorInterface $paginator): array
    {
        return $this->modelRepository->getAllModelWithBrand($paginator);
    }

    public function getTotalModelWithBrand(PaginatorInterface $paginator): int
    {
        return $this->modelRepository->getTotalModelWithBrand($paginator);
    }
}

