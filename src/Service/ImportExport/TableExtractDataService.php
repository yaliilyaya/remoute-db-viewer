<?php


namespace App\Service\ImportExport;


use App\Entity\ColumnDecorator;
use App\Entity\RemoteRelative;
use App\Entity\RemoteTable;
use App\Entity\RemoteTableColumn;

/**
 * Class TableExtractDataService
 * @package App\Service\ImportExport
 */
class TableExtractDataService
{
    public function getData(array $tables) :array
    {
        return array_map([$this, 'getTableData'], $tables);
    }

    /**
     * @param RemoteTable $table
     * @return array
     */
    protected function getTableData(RemoteTable $table): array
    {
        $columns = array_map([$this, 'getColumnData'], iterator_to_array($table->getColumns()));

        return [
            'id' => $table->getId(),
            'name' => $table->getDatabase()->getAlias().'.'.$table->getName(),
            'description' => (string)$table->getDescription(),
            'isActive' => $table->isActive(),
            'columns' => $columns
        ];
    }

    /**
     * @param RemoteTableColumn $column
     * @return array
     */
    protected function getColumnData(RemoteTableColumn $column): array
    {
        $decorators = array_map([$this, 'getDecoratorData'], iterator_to_array($column->getDecorators()));
        $relations = array_map([$this, 'getRelationData'], iterator_to_array($column->getRelations()));

        return [
            'id' => $column->getId(),
            'name' => $column->getName(),
            'description' => (string)$column->getDescription(),
            'decorators' => $decorators,
            'relations' => $relations,
        ];
    }

    /**
     * @param ColumnDecorator $decorator
     * @return array
     */
    protected function getDecoratorData(ColumnDecorator $decorator): array
    {
        return [
            'type' => $decorator->getType(),
            'parameter' => $decorator->getParameter(),
        ];
    }

    /**
     * @param RemoteRelative $relation
     * @return array
     */
    protected function getRelationData(RemoteRelative $relation): array
    {
        return [
            'type' => $relation->getColumnTo() ? $relation->getColumnTo()->getFullName() : null,
            'query' => $relation->getQuery(),
        ];
    }
}