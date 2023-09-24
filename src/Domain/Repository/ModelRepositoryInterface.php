<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Model\Model;

interface ModelRepositoryInterface
{
    public function findById(int $id): ?Model;

    public function getAllModelWithBrand(): array;

    public function findOneBy(array $criteria, array $orderBy = null);
}
