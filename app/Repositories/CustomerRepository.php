<?php 

namespace App\Repositories;


class CustomerRepository extends Repository
{
    /**
     * CustomerRepository constructor.
     *
     * @param \App\Models\Customer $model
     */
    public function __construct(\App\Models\Customer $model)
    {
        $this->model = $model;
    }
}