<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NseriesRepository")
 */
class Nseries
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Producent", inversedBy="nseries")
     */
    private $producent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movies", mappedBy="nseries")
     */
    private $movies;

    public function __construct()
    {
        $this->producent = new ArrayCollection();
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Producent[]
     */
    public function getProducent(): Collection
    {
        return $this->producent;
    }

    public function addProducent(Producent $producent): self
    {
        if (!$this->producent->contains($producent)) {
            $this->producent[] = $producent;
        }

        return $this;
    }

    public function removeProducent(Producent $producent): self
    {
        if ($this->producent->contains($producent)) {
            $this->producent->removeElement($producent);
        }

        return $this;
    }

    /**
     * @return Collection|Movies[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movies $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->setNseries($this);
        }

        return $this;
    }

    public function removeMovie(Movies $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            // set the owning side to null (unless already changed)
            if ($movie->getNseries() === $this) {
                $movie->setNseries(null);
            }
        }

        return $this;
    }
}
