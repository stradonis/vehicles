<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Vehicle\Vehicle;

interface VehicleRepositoryInterface
{
    public function findById(int $id): ?Vehicle;

    public function findAllArray(): array;

    public function save(Vehicle $vehicle, bool $flush = true): void;

    public function remove(Vehicle $vehicle): void;

    public function findOneByRegistrationNumber(string $value): ?Vehicle;

    public function findOneByRegistrationNumberWithoutUuid(string $registrationNumber, string $uuid): ?Vehicle;

    public function findOneBy(array $criteria, array $orderBy = null);
}
