<?php


namespace App\Entity\EntityTrait;


trait EntityIdentifierTrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int|null
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return EntityIdentifierTrait
     */
    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }
}