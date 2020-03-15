<?php


namespace App\Entity;


class Row
{
    /**
     * @var array
     */
    private $data;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return Row
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}