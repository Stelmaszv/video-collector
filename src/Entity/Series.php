<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeriesRepository")
 */
class Series
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movies", mappedBy="series")
     */
    private $movies;
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    /**
     * @ORM\Column(type="string", length=250)
     */
    private $avatar;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producent", inversedBy="series")
     */
    private $Producent;

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
        return $this->description;
    }

    public function setDescription(string $name): self
    {
        $this->description = $name;

        return $this;
    }
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $name): self
    {
        $this->avatar = $name;

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
            $movie->setSeries($this);
        }

        return $this;
    }

    public function removeMovie(Movies $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            // set the owning side to null (unless already changed)
            if ($movie->getSeries() === $this) {
                $movie->setSeries(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->name;
    }

    public function getProducent(): ?Producent
    {
        return $this->Producent;
    }

    public function setProducent(?Producent $Producent): self{
        $this->Producent = $Producent;
        return $this;
    }
    
}
