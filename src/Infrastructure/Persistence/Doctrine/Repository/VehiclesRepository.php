<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Vehicle\Vehicle;
use App\Domain\Repository\VehicleRepositoryInterface;
use App\UI\Http\Paginator\PaginatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception;

/**
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiclesRepository extends ServiceEntityRepository implements VehicleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findById(int $id): ?Vehicle
    {
        return $this->find($id);
    }

    public function findAllArray(PaginatorInterface $paginator): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
           SELECT registration_number, creation_date, modification_date , m.model_name model,
                  b.brand_name brand, m.uuid model_id, v.uuid id
            FROM vehicle v
                LEFT JOIN model m  ON m.id = v.model_id
                LEFT JOIN brand b  ON b.id = m.brand_id
            LIMIT :page OFFSET :offsetPage 
            ';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue("page", $paginator->getItemsPerPage());
        $stmt->bindValue("offsetPage", $paginator->getOffset());
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function getTotal(PaginatorInterface $paginator): int
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT COUNT(*) FROM vehicle v';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $paginator->getNumberOfPages((int)$resultSet->fetchOne());
    }

    public function save(Vehicle $vehicle, bool $flush = true): void
    {
        $this->getEntityManager()->persist($vehicle);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vehicle $vehicle): void
    {
        $this->getEntityManager()->remove($vehicle);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByRegistrationNumber(string $value): ?Vehicle
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.registrationNumber = :val')
            ->setParameter('val', strtoupper($value))
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByRegistrationNumberWithoutUuid(string $registrationNumber, string $uuid): ?Vehicle
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.registrationNumber = :val')
            ->andWhere('v.uuid != :uuid')
            ->setParameter('val', strtoupper($registrationNumber))
            ->setParameter('uuid', strtoupper($uuid))
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
