<?php

namespace App\Repository\Eloquent;

use App\Models\Type;
use App\Repository\TypeRepositoryInterface;

class TypeRepository extends BaseRepository implements TypeRepositoryInterface
{
   /**
    * TypeRepository constructor.
    *
    * @param Type $model
    */
   public function __construct(Type $model)
   {
       parent::__construct($model);
   }
}
