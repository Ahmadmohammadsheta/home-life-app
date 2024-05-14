<?php
namespace App\Repository;

use App\Models\Type;

interface TypeRepositoryInterface
{

   /**
    * columnsAsKeysAndValues
    * @return array
    */
    public function columns(): array;
}
