<?php


namespace App\Model;


class RowValue
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
     * @return RowValue
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}