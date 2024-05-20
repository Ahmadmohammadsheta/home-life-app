<?php
namespace App\Repository;

interface ProjectRepositoryInterface
{

   /**
    * columnsAsKeysAndValues
    * @return array
    */
    public function columns(): array;

   /**
    * getColumnType
    * @return array
    */
    public function columnsTypes(): array;
    
    /**
     * getColumnType
     * @param id $categoryId
     * @return array
     */
     public function arrayForSelectInput(): array;
}
