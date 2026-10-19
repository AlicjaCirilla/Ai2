<?php

namespace App\Entity;

use App\Repository\MeasurmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurmentRepository::class)]
class Measurment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'measurments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 0)]
    private ?string $Temperature = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 1)]
    private ?string $Atmospheric_pressure = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cloudiness = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Wind = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->Temperature;
    }

    public function setTemperature(string $Temperature): static
    {
        $this->Temperature = $Temperature;

        return $this;
    }

    public function getAtmosphericPressure(): ?string
    {
        return $this->Atmospheric_pressure;
    }

    public function setAtmosphericPressure(string $Atmospheric_pressure): static
    {
        $this->Atmospheric_pressure = $Atmospheric_pressure;

        return $this;
    }

    public function getCloudiness(): ?string
    {
        return $this->cloudiness;
    }

    public function setCloudiness(?string $cloudiness): static
    {
        $this->cloudiness = $cloudiness;

        return $this;
    }

    public function getWind(): ?string
    {
        return $this->Wind;
    }

    public function setWind(?string $Wind): static
    {
        $this->Wind = $Wind;

        return $this;
    }
}
