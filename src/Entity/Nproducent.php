<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NproducentRepository")
 */
class Nproducent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stars", inversedBy="nproducents")
     */
    private $stars;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movies", mappedBy="nproducent")
     */
    private $series;

    public function __construct()
    {
        $this->stars = new ArrayCollection();
        $this->series = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Stars[]
     */
    public function getStars(): Collection
    {
        return $this->stars;
    }

    public function addStar(Stars $star): self
    {
        if (!$this->stars->contains($star)) {
            $this->stars[] = $star;
        }

        return $this;
    }

    public function removeStar(Stars $star): self
    {
        if ($this->stars->contains($star)) {
            $this->stars->removeElement($star);
        }

        return $this;
    }

    /**
     * @return Collection|Movies[]
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }

    public function addSeries(Movies $series): self
    {
        if (!$this->series->contains($series)) {
            $this->series[] = $series;
            $series->setNproducent($this);
        }

        return $this;
    }

    public function removeSeries(Movies $series): self
    {
        if ($this->series->contains($series)) {
            $this->series->removeElement($series);
            // set the owning side to null (unless already changed)
            if ($series->getNproducent() === $this) {
                $series->setNproducent(null);
            }
        }

        return $this;
    }
}
