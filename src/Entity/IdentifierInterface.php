<?php


namespace App\Entity;


use App\Entity\EntityTrait\EntityIdentifierTrait;

interface IdentifierInterface
{
    /**
     * @return int|null
     */
    public function getId() :int;

    /**
     * @param int|null $id
     * @return EntityIdentifierTrait
     */
    public function setId(?int $id);
}