<?php

namespace App\Repository\Eloquent;

use App\Models\Project;
use App\Repository\ProjectRepositoryInterface;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
   /**
    * ProjectRepository constructor.
    *
    * @param Project $model
    */
   public function __construct(Project $model)
   {
       parent::__construct($model);
   }
}
