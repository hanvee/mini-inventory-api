<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Repository;

class ProductRepository extends Repository
{
    /**
     * ProductRepository constructor.
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
}