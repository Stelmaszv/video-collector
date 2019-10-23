<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StarsRepository")
 */
class Stars
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
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;
    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movies", mappedBy="stars")
     */
    private $movies;
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Series", mappedBy="Movies")
     */
    private $series;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stars", mappedBy="producent")
     */
    private $producent;
    

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
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $name): self
    {
        $this->avatar = $name;

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
            $movie->addStar($this);
        }

        return $this;
    }

    public function removeMovie(Movies $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            $movie->removeStar($this);
        }

        return $this;
    }
    public function getSeries(): Collection
    {
        return $this->series;
    }

    public function addSeries(Movies $movie): self
    {
        if (!$this->series->contains($movie)) {
            $this->series[] = $movie;
            $movie->setSeries($this);
        }

        return $this;
    }

    public function removeSeries(Movies $movie): self
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
}
