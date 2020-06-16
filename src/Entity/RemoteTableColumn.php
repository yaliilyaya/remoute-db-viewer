<?php


namespace App\Entity;

use App\Entity\EntityTrait\EntityIdentifierTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Class RemoteTableColumn
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RemoteTableColumnRepository")
 */
class RemoteTableColumn
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
     * @ORM\Column(type="boolean", options={"default": "TRUE"})
     * @var boolean
     */
    private $isViewList;
    /**
     * @ORM\Column(type="boolean", options={"default": "TRUE"})
     * @var boolean
     */
    private $isViewDetail;
    /**
     * @ORM\Column(type="boolean", options={"default": "TRUE"})
     * @var boolean
     */
    private $isViewPopup;

    /**
     * @ManyToOne(targetEntity="App\Entity\RemoteTable", inversedBy="columns"))
     * @var RemoteTable
     */
    private $table;

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
     * @return RemoteTableColumn
     */
    public function setId(int $id): RemoteTableColumn
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
     * @return RemoteTableColumn
     */
    public function setLabel(string $label): RemoteTableColumn
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
     * @return RemoteTableColumn
     */
    public function setName(string $name): RemoteTableColumn
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
     * @return RemoteTableColumn
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
     * @return RemoteTableColumn
     */
    public function setDescription(?string $description): RemoteTableColumn
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
     * @return RemoteTableColumn
     */
    public function setIsViewList(bool $isViewList): RemoteTableColumn
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
     * @return RemoteTableColumn
     */
    public function setIsViewDetail(bool $isViewDetail): RemoteTableColumn
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
     * @return RemoteTableColumn
     */
    public function setIsViewPopup(bool $isViewPopup): RemoteTableColumn
    {
        $this->isViewPopup = $isViewPopup;
        return $this;
    }

    /**
     * @return RemoteTable
     */
    public function getTable(): RemoteTable
    {
        return $this->table;
    }

    /**
     * @param RemoteTable $table
     * @return RemoteTableColumn
     */
    public function setTable(RemoteTable $table): RemoteTableColumn
    {
        $this->table = $table;
        return $this;
    }
}