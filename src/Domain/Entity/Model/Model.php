<?php

namespace App\Domain\Entity\Model;

use App\Domain\Entity\Brand\Brand;
use App\Domain\ValueObject\ModelName;
use App\Infrastructure\Persistence\Doctrine\Repository\ModelRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;

#[ORM\Entity(repositoryClass: ModelRepository::class)]
class Model
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'model_name')]
    private ModelName $modelName;

    #[ORM\ManyToOne(inversedBy: 'model')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    protected string $uuid;

    public function __construct(ModelName $modelName)
    {
        $this->modelName = $modelName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelName(): ModelName
    {
        return $this->modelName;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function setUuid($uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }
}
