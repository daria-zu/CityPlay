<?php

namespace App\Entity;

use App\Repository\PlaygroundRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaygroundRepository::class)
 * @ORM\Table(name="tb_playgrounds")
 */
class Playground
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $possition_x;

    /**
     * @ORM\Column(type="float")
     */
    private $possition_y;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $district;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="float")
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="playground")
     */
    private $reviews;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->image = 'default-image.png';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPossitionX(): ?float
    {
        return $this->possition_x;
    }

    public function setPossitionX(float $possition_x): self
    {
        $this->possition_x = $possition_x;

        return $this;
    }

    public function getPossitionY(): ?float
    {
        return $this->possition_y;
    }

    public function setPossitionY(float $possition_y): self
    {
        $this->possition_y = $possition_y;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(?string $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): self
    {
        $this->rating = prating;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setPlayground($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getPlayground() === $this) {
                $review->setPlayground(null);
            }
        }

        return $this;
    }
}
