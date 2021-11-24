<?php

namespace App\Entity;

use App\Repository\ImageStockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageStockRepository::class)
 */
class ImageStock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_name;

    /**
     * @ORM\OneToMany(targetEntity=Tags::class, mappedBy="imageStock",cascade={"persist"}, fetch="LAZY")
     */
    private $tags;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $tag_demo;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageName(): ?string
    {
        return $this->image_name;
    }

    public function setImageName(string $image_name): self
    {
        $this->image_name = $image_name;

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
            $tag->setImageStock($this);
        }

        return $this;
    }

    public function removeTag(tags $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getImageStock() === $this) {
                $tag->setImageStock(null);
            }
        }

        return $this;
    }

    // public function getTagDemo(): ?string
    // {
    //     return $this->tag_demo;
    // }

    // public function setTagDemo(string $tag_demo): self
    // {
    //     $this->tag_demo = $tag_demo;

    //     return $this;
    // }

}
