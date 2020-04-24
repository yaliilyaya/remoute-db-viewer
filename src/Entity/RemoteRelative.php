<?php


namespace App\Entity;

use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RemoteRelative
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RemoteRelativeRepository")
 * Связи между таблицами являються абстрактными, ибо может быть случаи не травиальной связи - значение из закодированного пакета xml
 * Всегда связь идёт от колонки(значение колонки) к первичному ключу таблици (один ко многим)
 */
class RemoteRelative
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int|null
     */
    private $id;
    /**
     * @var RemoteTable
     * @ManyToOne(targetEntity="App\Entity\RemoteTableColumn", inversedBy="tables")
     */
    private $columnFrom;
    /**
     * @var RemoteTable
     * @ManyToOne(targetEntity="App\Entity\RemoteTableColumn", inversedBy="tables")
     */
    private $columnTo;
    /**
     * TODO:: возможно json
     * @var string
     */
    private $query;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return RemoteRelative
     */
    public function setId(?int $id): RemoteRelative
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return RemoteTable
     */
    public function getColumnFrom(): RemoteTable
    {
        return $this->columnFrom;
    }

    /**
     * @param RemoteTable $columnFrom
     * @return RemoteRelative
     */
    public function setColumnFrom(RemoteTable $columnFrom): RemoteRelative
    {
        $this->columnFrom = $columnFrom;
        return $this;
    }

    /**
     * @return RemoteTable
     */
    public function getColumnTo(): RemoteTable
    {
        return $this->columnTo;
    }

    /**
     * @param RemoteTable $columnTo
     * @return RemoteRelative
     */
    public function setColumnTo(RemoteTable $columnTo): RemoteRelative
    {
        $this->columnTo = $columnTo;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     * @return RemoteRelative
     */
    public function setQuery(string $query): RemoteRelative
    {
        $this->query = $query;
        return $this;
    }
}