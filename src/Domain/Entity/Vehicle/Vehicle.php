<?php

namespace App\Domain\Entity\Vehicle;

use App\Domain\Entity\Model\Model;
use App\Domain\ValueObject\RegistrationNumber;
use App\Infrastructure\Persistence\Doctrine\Repository\VehiclesRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiclesRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'registration_number')]
    private RegistrationNumber $registrationNumber;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $creationDate;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $modificationDate;

    #[ORM\OneToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Model $model = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    protected string $uuid;

    public function __construct(RegistrationNumber $registrationNumber)
    {
        $this->modificationDate = new DateTimeImmutable();
        $this->registrationNumber = $registrationNumber;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistrationNumber(): RegistrationNumber
    {
        return $this->registrationNumber;
    }

    public function changerRegistrationNumber(RegistrationNumber $registrationNumber): void
    {
        $this->registrationNumber = $registrationNumber;
    }

    public function getCreationDate(): DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getModificationDate(): DateTimeInterface
    {
        return $this->modificationDate;
    }

    public function setModificationDate(DateTimeInterface $modification_date): static
    {
        $this->modificationDate = $modification_date;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function setUuid($uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
