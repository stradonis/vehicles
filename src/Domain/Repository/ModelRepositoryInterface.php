<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Model\Model;
use App\UI\Http\Paginator\PaginatorInterface;

interface ModelRepositoryInterface
{
    public function findById(int $id): ?Model;

    public function getAllModelWithBrand(PaginatorInterface $paginator): array;

    public function getTotalModelWithBrand(PaginatorInterface $paginator): int;

    public function findOneBy(array $criteria, array $orderBy = null);
}
