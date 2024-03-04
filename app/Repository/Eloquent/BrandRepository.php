<?php

namespace App\Repository\Eloquent;

use App\Models\Brand;
use App\Repository\BrandRepositoryInterface;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
   /**
    * BrandRepository constructor.
    *
    * @param Brand $model
    */
   public function __construct(Brand $model)
   {
       parent::__construct($model);
   }
}
