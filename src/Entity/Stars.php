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
     * @ORM\ManyToMany(targetEntity="App\Entity\Movies", mappedBy="stars")
     */
    private $movies;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Series", mappedBy="stars")
     */
    private $series;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Producent", inversedBy="stars")
     */
    private $Producent;

    public function __construct()
    {
        $this->producents = new ArrayCollection();
        $this->movies = new ArrayCollection();
        $this->series = new ArrayCollection();
        $this->Producent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

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
            $series->setStars($this);
        }

        return $this;
    }

    public function removeSeries(Series $series): self
    {
        if ($this->series->contains($series)) {
            $this->series->removeElement($series);
            // set the owning side to null (unless already changed)
            if ($series->getStars() === $this) {
                $series->setStars(null);
            }
        }

        return $this;
    }
    function __toString(){
        return $this->name;
    }

    /**
     * @return Collection|Producent[]
     */
    public function getProducent(): Collection
    {
        return $this->Producent;
    }

    public function addProducent(Producent $producent): self
    {
        if (!$this->Producent->contains($producent)) {
            $this->Producent[] = $producent;
        }

        return $this;
    }

    public function removeProducent(Producent $producent): self
    {
        if ($this->Producent->contains($producent)) {
            $this->Producent->removeElement($producent);
        }

        return $this;
    }
}
