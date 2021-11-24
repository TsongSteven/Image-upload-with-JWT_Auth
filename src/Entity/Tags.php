<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tags", indexes={@ORM\Index(name="IDX_6FBC9426823DEFB8", columns={"image_stock_id"})})
 * @ORM\Entity
 */
class Tags
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tag_name", type="string", length=255, nullable=false)
     */
    private $tagName;

    /**
     * @var \ImageStock
     *
     * @ORM\ManyToOne(targetEntity="ImageStock")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_stock_id", referencedColumnName="id")
     * })
     */
    private $imageStock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagName(): ?string
    {
        return $this->tagName;
    }

    public function setTagName(string $tagName): self
    {
        $this->tagName = $tagName;

        return $this;
    }

    public function getImageStock(): ?ImageStock
    {
        return $this->imageStock;
    }

    public function setImageStock(?ImageStock $imageStock): self
    {
        $this->imageStock = $imageStock;

        return $this;
    }


}
