<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\TypeRepository;
use App\Repository\TypeRepositoryInterface;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\ProjectRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\ThingRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\ThingRepositoryInterface;

/**
* Class RepositoryServiceProvider
* @package App\Providers
*/
class RepositoryServiceProvider extends ServiceProvider
{
   /**
    * Register services.
    *
    * @return void
    */
   public function register()
   {
       $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
       $this->app->bind(TypeRepositoryInterface::class, TypeRepository::class);
       $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
       $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
       $this->app->bind(ThingRepositoryInterface::class, ThingRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
