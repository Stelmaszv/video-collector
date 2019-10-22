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
     * @ORM\Column(type="string", length=255)
     */
    private $name;
     /**
     * @ORM\Column(type="string", length=255)
     */
    private $muvieSrc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stars", inversedBy="movies")
     */
    private $stars;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producent", inversedBy="movies")
     */
    private $producent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tags", inversedBy="movies")
     */
    private $tags;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cantry", inversedBy="movies")
     */
    private $cantry;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Series", inversedBy="movies")
     */
    private $series;

    /**
     * @ORM\Column(type="boolean")
     */
    private $link;

    public function __construct()
    {
        $this->stars = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $name): self
    {
        $this->link = $name;

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
    public function getMuvie_src(): ?string
    {
        return $this->muvieSrc;
    }

    public function setMuvie_src(string $name): self
    {
        $this->muvieSrc = $name;

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
     * @return Collection|stars[]
     */
    public function getStars(): Collection
    {
        return $this->stars;
    }

    public function addStar(stars $star): self
    {
        if (!$this->stars->contains($star)) {
            $this->stars[] = $star;
        }

        return $this;
    }

    public function removeStar(stars $star): self
    {
        if ($this->stars->contains($star)) {
            $this->stars->removeElement($star);
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

    public function getProducent(): ?producent
    {
        return $this->producent;
    }

    public function setProducent(?producent $producent): self
    {
        $this->producent = $producent;

        return $this;
    }

    /**
     * @return Collection|tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(tags $tag): self
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

    public function getCantry(): ?cantry
    {
        return $this->cantry;
    }

    public function setCantry(?cantry $cantry): self
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
}
