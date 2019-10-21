<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProducentRepository")
 */
class Producent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    /**
     * @ORM\Column(type="string", length=250)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movies", mappedBy="producent")
     */
    private $movies;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stars", inversedBy="producent")
     */
    private $stars;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Series", mappedBy="producent")
     */
    private $series;

    public function __construct()
    {
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
        return $this->name;
    }

    public function setDescription(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $name): self
    {
        $this->avatar = $avatar;

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
            $movie->setProducent($this);
        }

        return $this;
    }

    public function removeMovie(Movies $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            // set the owning side to null (unless already changed)
            if ($movie->getProducent() === $this) {
                $movie->setProducent(null);
            }
        }

        return $this;
    }
     /**
     * @return Collection|Series[]
     */
    public function getSeries(): Collection{
        return $this->series;
    }
}
