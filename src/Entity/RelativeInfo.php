<?php


namespace App\Entity;

use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RelativeInfo
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RemoteRelativeRepository")
 * Связи между таблицами являються абстрактными, ибо может быть случаи не травиальной связи - значение из закодированного пакета xml
 * Всегда связь идёт от колонки(значение колонки) к первичному ключу таблици (многие к одному)
 * TODO:: вынесем создание связи на колонки не являющимися первичным ключём
 */
class RelativeInfo
{
    use IdentifierTrait;

    /**
     * Колонка первичного ключа  для связи на детальную информацию
     * @var ColumnInfo
     * @ManyToOne(targetEntity="App\Entity\ColumnInfo", inversedBy="tables")
     */
    private $columnFrom;
    /**
     * Колонка с первичным ключём для связи с таблицей
     * @var ColumnInfo
     * @ManyToOne(targetEntity="App\Entity\ColumnInfo", inversedBy="tables")
     */
    private $columnTo;
    /**
     * TODO:: возможно json
     * @var string|null
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
     * @return RelativeInfo
     */
    public function setId(?int $id): RelativeInfo
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ColumnInfo
     */
    public function getColumnFrom(): ColumnInfo
    {
        return $this->columnFrom;
    }

    /**
     * @param ColumnInfo $columnFrom
     * @return RelativeInfo
     */
    public function setColumnFrom(ColumnInfo $columnFrom): RelativeInfo
    {
        $this->columnFrom = $columnFrom;
        return $this;
    }

    /**
     * @return ColumnInfo
     */
    public function getColumnTo(): ?ColumnInfo
    {
        return $this->columnTo;
    }

    /**
     * @param ColumnInfo $columnTo
     * @return RelativeInfo
     */
    public function setColumnTo(ColumnInfo $columnTo): RelativeInfo
    {
        $this->columnTo = $columnTo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * @param string|null $query
     * @return RelativeInfo
     */
    public function setQuery(?string $query): RelativeInfo
    {
        $this->query = $query;
        return $this;
    }
}