<?php


namespace App\Entity;

use App\Entity\EntityTrait\EntityIdentifierTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\PersistentCollection;

/**
 * Class ColumnInfo
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RemoteTableColumnRepository")
 */
class ColumnInfo
{
    use EntityIdentifierTrait;

    public const TYPE_DETAIL = 'detail';
    public const TYPE_LIST = 'list';


    /**
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    private $label;
    /**
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=50)
     * @var mixed
     */
    private $type;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $description;
    /**
     * @ORM\Column(type="boolean", options={"default": "1"})
     * @var boolean
     */
    private $isViewList;
    /**
     * @ORM\Column(type="boolean", options={"default": "1"})
     * @var boolean
     */
    private $isViewDetail;
    /**
     * @ORM\Column(type="boolean", options={"default": "1"})
     * @var boolean
     */
    private $isViewPopup;

    /**
     * @ManyToOne(targetEntity="App\Entity\TableInfo", inversedBy="columns"))
     * @var TableInfo
     */
    private $table;

    /**
     * @OneToMany(targetEntity="\App\Entity\ColumnDecorator", mappedBy="column", fetch="EXTRA_LAZY")
     *
     * @var PersistentCollection
     */
    private $decorators;

    public function __construct()
    {
        $this->isViewList = false;
        $this->isViewDetail = false;
        $this->isViewPopup = false;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ColumnInfo
     */
    public function setId(int $id): ColumnInfo
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return ColumnInfo
     */
    public function setLabel(string $label): ColumnInfo
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ColumnInfo
     */
    public function setName(string $name): ColumnInfo
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return ColumnInfo
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return ColumnInfo
     */
    public function setDescription(?string $description): ColumnInfo
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isViewList(): bool
    {
        return $this->isViewList;
    }

    /**
     * @param bool $isViewList
     * @return ColumnInfo
     */
    public function setIsViewList(bool $isViewList): ColumnInfo
    {
        $this->isViewList = $isViewList;
        return $this;
    }

    /**
     * @return bool
     */
    public function isViewDetail(): bool
    {
        return $this->isViewDetail;
    }

    /**
     * @param bool $isViewDetail
     * @return ColumnInfo
     */
    public function setIsViewDetail(bool $isViewDetail): ColumnInfo
    {
        $this->isViewDetail = $isViewDetail;
        return $this;
    }

    /**
     * @return bool
     */
    public function isViewPopup(): bool
    {
        return $this->isViewPopup;
    }

    /**
     * @param bool $isViewPopup
     * @return ColumnInfo
     */
    public function setIsViewPopup(bool $isViewPopup): ColumnInfo
    {
        $this->isViewPopup = $isViewPopup;
        return $this;
    }

    /**
     * @return TableInfo
     */
    public function getTable(): TableInfo
    {
        return $this->table;
    }

    /**
     * @param TableInfo $table
     * @return ColumnInfo
     */
    public function setTable(TableInfo $table): ColumnInfo
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getDecorators(): PersistentCollection
    {
        return $this->decorators;
    }

    /**
     * @param PersistentCollection $decorators
     * @return ColumnInfo
     */
    public function setDecorators(PersistentCollection $decorators): ColumnInfo
    {
        $this->decorators = $decorators;
        return $this;
    }


}