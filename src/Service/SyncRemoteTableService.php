<?php

namespace App\Service;

use App\Entity\DataBase;

/**
 * Class SyncRemoteTableService
 * @package App\Service
 */
class SyncRemoteTableService
{
    /**
     * @param DataBase[] $dataBases
     */
    public function sync(array $dataBases)
    {
        foreach ($dataBases as $dataBase)
        {
            $this->syncTables($dataBase);
        }
    }

    private function syncTables(DataBase $dataBase)
    {
        //TODO:: обработать список таблич и информации по ней сохранять в нашей бд
    }
}