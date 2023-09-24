<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Model\Model;
use App\Domain\Repository\ModelRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends ServiceEntityRepository implements ModelRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }

    public function findById(int $id): ?Model
    {
        return $this->find($id);
    }

    /**
     * @throws Exception
     */
    public function getAllModelWithBrand(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT m.uuid, b.brand_name brand, m.model_name model
                FROM model m INNER JOIN brand b on b.id = m.brand_id
                ORDER BY brand_name, model_name';

        $resultSet = $conn->executeQuery($sql);
        $result = $resultSet->fetchAllAssociative();
        $models = [];

        foreach ($result as $value) {
            $models[] = ['id' => $value['uuid'], 'name' => $value['model'] .' [' . $value['brand'] . ']'];
        }

        return $models;
    }
}
