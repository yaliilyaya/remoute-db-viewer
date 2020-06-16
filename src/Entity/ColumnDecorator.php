<?php


namespace App\Entity;

use App\Entity\EntityTrait\EntityIdentifierTrait;

/**
 * Class RemoteTableColumn
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ColumnDecoratorRepository")
 */
class ColumnDecorator
{
    use EntityIdentifierTrait;
}