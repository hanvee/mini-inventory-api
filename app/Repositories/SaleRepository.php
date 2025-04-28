<?php

namespace App\Repositories;

use App\Models\Sale;

class SaleRepository extends Repository
{
    /**
     * SaleRepository constructor.
     *
     * @param \App\Models\Sale $model
     */
    public function __construct(Sale $model)
    {
        $this->model = $model;
    }
}
