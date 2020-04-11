<?php


namespace App\Entity;


class RemoteTableColumn
{
    public const TYPE_DETAIL = 'detail';
    public const TYPE_LIST = 'list';

    /**
     * @var string
     */
    private $label;
    /**
     * @var string
     */
    private $name;
    /**
     * @var mixed
     */
    private $type;
    /**
     * @var string
     */
    private $description;
    /**
     * @var boolean
     */
    private $isViewList;
    /**
     * @var boolean
     */
    private $isViewDetail;
    /**
     * @var boolean
     */
    private $isViewPopup;

    public function __construct()
    {
        $this->isViewList = false;
        $this->isViewDetail = false;
        $this->isViewPopup = false;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return RemoteTableColumn
     */
    public function setDescription(string $description): RemoteTableColumn
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
}