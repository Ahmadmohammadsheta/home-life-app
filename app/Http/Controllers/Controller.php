<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SqlDataRetrievable; // AMA custom trait
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests,
        ValidatesRequests,
        SqlDataRetrievable; // AMA custom use

    /**
     * AMA custom
     * Properties
     */
    public $repository;
    public $model;
    public $additionalData;
    public $uriRoute;
    public $service;

    /**
     * AMA custom
     * requestData method
     */
    public function additionalData(Model $model, $modelObjectName) {
        $this->model = $model;
        return [
            'tableName' => $this->modelTableName($this->model),
            'modelObjectName' => $modelObjectName
        ];
    }
}
