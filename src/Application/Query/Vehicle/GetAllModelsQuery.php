<?php

declare(strict_types=1);

namespace App\Application\Query\Vehicle;

use App\Domain\Repository\ModelRepositoryInterface;

readonly class GetAllModelsQuery
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository
    ) {
    }

    public function getAll(): array
    {
        return $this->modelRepository->getAllModelWithBrand();
    }
}

