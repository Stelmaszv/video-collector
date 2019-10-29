<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestRepository")
 */
class Test
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
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
     * @ORM\OneToMany(targetEntity="App\Entity\Series", mappedBy="stars")
     */
    private $series;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Producent", inversedBy="stars")
     */
    private $producent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movies", inversedBy="stars")
     */
    private $movies;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Nproducent", mappedBy="stars")
     */
    private $nproducents;

    public function __construct()
    {
        $this->series = new ArrayCollection();
        $this->producent = new ArrayCollection();
        $this->movies = new ArrayCollection();
        $this->nproducents = new ArrayCollection();
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

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

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
            $series->setNstars($this);
        }

        return $this;
    }

    public function removeSeries(Series $series): self
    {
        if ($this->series->contains($series)) {
            $this->series->removeElement($series);
            // set the owning side to null (unless already changed)
            if ($series->getNstars() === $this) {
                $series->setNstars(null);
            }
        }

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
        }

        return $this;
    }

    public function removeMovie(Movies $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
        }

        return $this;
    }

    /**
     * @return Collection|Nproducent[]
     */
    public function getNproducents(): Collection
    {
        return $this->nproducents;
    }

    public function addNproducent(Nproducent $nproducent): self
    {
        if (!$this->nproducents->contains($nproducent)) {
            $this->nproducents[] = $nproducent;
            $nproducent->addStar($this);
        }

        return $this;
    }

    public function removeNproducent(Nproducent $nproducent): self
    {
        if ($this->nproducents->contains($nproducent)) {
            $this->nproducents->removeElement($nproducent);
            $nproducent->removeStar($this);
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MoviesRepository")
 */
class Movies
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $movieSrc;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stars", inversedBy="Movies")
     */
    private $stars;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tags", inversedBy="Movies")
     */
    private $tags;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cantry", inversedBy="Movies")
     */
    private $cantry;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producent", inversedBy="Movies")
     */
    private $producent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nproducent", inversedBy="series")
     */
    private $nproducent;


    public function __construct()
    {
        $this->stars = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->nstars = new ArrayCollection();
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

    public function getMovieSrc(): ?string
    {
        return $this->movieSrc;
    }

    public function setMovieSrc(?string $movieSrc): self
    {
        $this->movieSrc = $movieSrc;

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
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getCantry(): ?Cantry
    {
        return $this->cantry;
    }

    public function setCantry(?Cantry $cantry): self
    {
        $this->cantry = $cantry;

        return $this;
    }

    public function getSeries(): ?Series
    {
        return $this->series;
    }

    public function setSeries(?Series $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getLink(): ?bool
    {
        return $this->link;
    }

    public function setLink(?bool $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getProducent(): ?Producent
    {
        return $this->producent;
    }

    public function setProducent(?Producent $producent): self
    {
        $this->producent = $producent;

        return $this;
    }

    public function getNseries(): ?Nseries
    {
        return $this->nseries;
    }

    public function setNseries(?Nseries $nseries): self
    {
        $this->nseries = $nseries;

        return $this;
    }

    /**
     * @return Collection|Nstars[]
     */
    public function getNstars(): Collection
    {
        return $this->nstars;
    }

    public function addNstar(Nstars $nstar): self
    {
        if (!$this->nstars->contains($nstar)) {
            $this->nstars[] = $nstar;
            $nstar->addMovie($this);
        }

        return $this;
    }

    public function removeNstar(Nstars $nstar): self
    {
        if ($this->nstars->contains($nstar)) {
            $this->nstars->removeElement($nstar);
            $nstar->removeMovie($this);
        }

        return $this;
    }

    public function getNproducent(): ?Nproducent
    {
        return $this->nproducent;
    }

    public function setNproducent(?Nproducent $nproducent): self
    {
        $this->nproducent = $nproducent;

        return $this;
    }
}
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

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CantryRepository")
 */
class Cantry
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
     * @ORM\OneToMany(targetEntity="App\Entity\Movies", mappedBy="Cantry")
     */
    private $Movies;



    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->nMovies = new ArrayCollection();
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
            $movie->setCantry($this);
        }

        return $this;
    }

    public function removeMovie(Movies $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            // set the owning side to null (unless already changed)
            if ($movie->getCantry() === $this) {
                $movie->setCantry(null);
            }
        }

        return $this;
    }

}