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
     * @ORM\Column(type="string", length=255)
     */
    private $name;
        /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Series", mappedBy="producent")
     */
    private $series;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stars", inversedBy="producents")
     */
    private $movies;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stars", mappedBy="Producent")
     */
    private $stars;

    public function __construct()
    {
        $this->series = new ArrayCollection();
        $this->stars = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Series[]
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }

    public function addSeries(Series $series): self
    {
        if (!$this->series->contains($series)) {
            $this->series[] = $series;
            $series->setProducent($this);
        }

        return $this;
    }

    public function removeSeries(Series $series): self
    {
        if ($this->series->contains($series)) {
            $this->series->removeElement($series);
            // set the owning side to null (unless already changed)
            if ($series->getProducent() === $this) {
                $series->setProducent(null);
            }
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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
    function __toString(){
        return $this->name;
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
            $star->addProducent($this);
        }

        return $this;
    }

    public function removeStar(Stars $star): self
    {
        if ($this->stars->contains($star)) {
            $this->stars->removeElement($star);
            $star->removeProducent($this);
        }

        return $this;
    }
}
