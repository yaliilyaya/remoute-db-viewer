<?php


namespace App\Entity;

use App\Entity\EntityTrait\EntityIdentifierTrait;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RemoteRelative
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RemoteRelativeRepository")
 * Связи между таблицами являються абстрактными, ибо может быть случаи не травиальной связи - значение из закодированного пакета xml
 * Всегда связь идёт от колонки(значение колонки) к первичному ключу таблици (многие к одному)
 * TODO:: вынесем создание связи на колонки не являющимися первичным ключём
 */
class RemoteRelative
{
    use EntityIdentifierTrait;

    /**
     * Колонка первичного ключа  для связи на детальную информацию
     * @var RemoteTableColumn
     * @ManyToOne(targetEntity="App\Entity\RemoteTableColumn", inversedBy="tables")
     */
    private $columnFrom;
    /**
     * Колонка с первичным ключём для связи с таблицей
     * @var RemoteTableColumn
     * @ManyToOne(targetEntity="App\Entity\RemoteTableColumn", inversedBy="tables")
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
     * @return RemoteRelative
     */
    public function setId(?int $id): RemoteRelative
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return RemoteTableColumn
     */
    public function getColumnFrom(): RemoteTableColumn
    {
        return $this->columnFrom;
    }

    /**
     * @param RemoteTableColumn $columnFrom
     * @return RemoteRelative
     */
    public function setColumnFrom(RemoteTableColumn $columnFrom): RemoteRelative
    {
        $this->columnFrom = $columnFrom;
        return $this;
    }

    /**
     * @return RemoteTableColumn
     */
    public function getColumnTo(): ?RemoteTableColumn
    {
        return $this->columnTo;
    }

    /**
     * @param RemoteTableColumn $columnTo
     * @return RemoteRelative
     */
    public function setColumnTo(RemoteTableColumn $columnTo): RemoteRelative
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
     * @return RemoteRelative
     */
    public function setQuery(?string $query): RemoteRelative
    {
        $this->query = $query;
        return $this;
    }
}