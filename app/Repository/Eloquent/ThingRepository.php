<?php

namespace App\Repository\Eloquent;

use App\Models\Thing;
use App\Repository\ThingRepositoryInterface;

class ThingRepository extends BaseRepository implements ThingRepositoryInterface
{
   /**
    * ThingRepository constructor.
    *
    * @param Thing $model
    */
   public function __construct(Thing $model)
   {
       parent::__construct($model);
   }
}
