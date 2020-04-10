<?php


namespace App\Entity;


class Column
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
     * @return Column
     */
    public function setLabel(string $label): Column
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
     * @return Column
     */
    public function setName(string $name): Column
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
     * @return Column
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
     * @return Column
     */
    public function setDescription(string $description): Column
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
     * @return Column
     */
    public function setIsViewList(bool $isViewList): Column
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
     * @return Column
     */
    public function setIsViewDetail(bool $isViewDetail): Column
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
     * @return Column
     */
    public function setIsViewPopup(bool $isViewPopup): Column
    {
        $this->isViewPopup = $isViewPopup;
        return $this;
    }
}