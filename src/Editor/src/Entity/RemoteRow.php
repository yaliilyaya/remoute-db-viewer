<?php


namespace App\Entity;


class RemoteRow
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
     * @return RemoteRow
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}