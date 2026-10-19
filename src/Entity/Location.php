<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $City = null;

    #[ORM\Column(length: 2)]
    private ?string $Country = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $Latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $Longitude = null;

    /**
     * @var Collection<int, Measurment>
     */
    #[ORM\OneToMany(targetEntity: Measurment::class, mappedBy: 'location')]
    private Collection $measurments;

    public function __construct()
    {
        $this->measurments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): static
    {
        $this->City = $City;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): static
    {
        $this->Country = $Country;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    public function setLatitude(string $Latitude): static
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    public function setLongitude(string $Longitude): static
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    /**
     * @return Collection<int, Measurment>
     */
    public function getMeasurments(): Collection
    {
        return $this->measurments;
    }

    public function addMeasurment(Measurment $measurment): static
    {
        if (!$this->measurments->contains($measurment)) {
            $this->measurments->add($measurment);
            $measurment->setLocation($this);
        }

        return $this;
    }

    public function removeMeasurment(Measurment $measurment): static
    {
        if ($this->measurments->removeElement($measurment)) {
            // set the owning side to null (unless already changed)
            if ($measurment->getLocation() === $this) {
                $measurment->setLocation(null);
            }
        }

        return $this;
    }
}
