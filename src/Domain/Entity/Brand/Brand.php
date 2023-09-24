<?php

namespace App\Domain\Entity\Brand;

use App\Domain\Entity\Model\Model;
use App\Domain\ValueObject\BrandName;
use App\Infrastructure\Persistence\Doctrine\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'brand_name')]
    private BrandName $brandName;

    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: Model::class, orphanRemoval: true)]
    private Collection $models;

    #[ORM\Column(type: 'uuid', unique: true)]
    protected string $uuid;

    public function __construct(BrandName $brandName)
    {
        $this->models = new ArrayCollection();
        $this->brandName = $brandName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandName(): BrandName
    {
        return $this->brandName;
    }


    /**
     * @return Collection<int, Model>
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): static
    {
        if (!$this->models->contains($model)) {
            $this->models->add($model);
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(Model $model): static
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

        return $this;
    }

    public function setUuid($uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }
}
