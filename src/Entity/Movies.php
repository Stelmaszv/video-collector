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
     * @ORM\ManyToOne(targetEntity="App\Entity\Series", inversedBy="movies")
     */
    private $series;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $movieSrc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stars", inversedBy="movies")
     */
    private $stars;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tags", inversedBy="movies")
     */
    private $tags;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cantry", inversedBy="movies")
     */
    private $cantry;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $link;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producent", inversedBy="movies")
     */
    private $producent;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkSrc;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $views;

    public function __construct()
    {
        $this->stars = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getViews(): ?string
    {
        return $this->views;
    }

    public function setViews(?string $view): self
    {
        $this->views = $view;

        return $this;
    }
    public function getLinkSrc(): ?string
    {
        return $this->linkSrc;
    }

    public function setLinkSrc(?string $name): self
    {
        $this->linkSrc = $name;

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

    public function setDescription(?string $description): self
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

    public function setTime(?\DateTimeInterface $time): self
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
    function __toString(){
        return $this->name;
    }
}
