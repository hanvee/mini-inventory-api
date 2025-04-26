<?php

namespace App\Repositories;

use App\Traits\ApiRequester;
use Illuminate\Database\Eloquent\Model;

class Repository
{
    use ApiRequester;

    /**
     * @var Model
     */
    protected Model $model;

    /**
     * Repository constructor.
     * @param mixed $query
     * @return Model[]
     */
    public function getAll($query = null)
    {
        if (!$this->model) {
            return;
        }

        $request = $this->getRequest();
        $collection = $this->model;
        if ($query) {
            $collection = $query;
        }

        if ($request["sort_by"]) {
            if ($request["sort_direction"] == "desc") {
                $collection = $collection->orderByDesc($request["sort_by"]);
            } else {
                $collection = $collection->orderBy($request["sort_by"]);
            }
        }
        if ($request["keyword"]) {
            $collection = $collection->where(
                "name",
                "like",
                "%" . $request["keyword"] . "%"
            );
        }

        $data = $collection->paginate($request["per_page"]);
        return $data;
    }

    /**
     * @param array $filters
     * @param bool $or
     * @return Model[]
     */
    public function getAllWithFilters(array $filters = [], $or = false)
    {
        $query = $this->model;
        for ($i = 0; $i < count($filters); $i++) {
            if ($i === 0) {
                $query = $query->where(
                    $filters[$i]["field"],
                    $filters[$i]["value"]
                );
            } else {
                if ($or === true) {
                    $query = $query->orWhere(
                        $filters[$i]["field"],
                        $filters[$i]["value"]
                    );
                } else {
                    $query = $query->where(
                        $filters[$i]["field"],
                        $filters[$i]["value"]
                    );
                }
            }
        }
        return $this->getAll($query);
    }

    /**
     * @return Model[]
     */
    public function getAllWithDetails()
    {
        $query = $this->model->details();
        return $this->getAll($query);
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getById(int $id)
    {
        if (!$this->model) {
            return;
        }
        $data = $this->model->details()->findOrFail($id);
        return $data;
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string $comparator
     * @param bool $latest
     * @return Model
     */
    public function getByField(
        $field,
        $value,
        $comparator = "=",
        $latest = false
    ) {
        if (!$this->model) {
            return null;
        }
        $data = $this->model->details()->where($field, $comparator, $value);
        if ($latest) {
            $data = $data->orderByDesc("id");
        }
        return $data->firstOrFail();
    }

    /**
     * @param array $payload
     * @return Model
     */
    public function create(array $payload)
    {
        return $this->model->create($payload);
    }

    /**
     * @param int $id
     * @param array $payload
     * @return Model
     */
    public function update(int $id, array $payload)
    {
        $data = $this->getById($id);
        $data->update($payload);
        return $data;
    }

    /**
     * @param int $id
     * @return Model
     */
    public function delete(int $id)
    {
        $data = $this->getById($id);
        $data->delete();
        return $data;
    }

    /**
     * @param int $id
     * @return Model
     */
    public function forceDelete(int $id)
    {
        $data = $this->getById($id);
        $data->forceDelete();
        return $data;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function restore(int $id)
    {
        return $this->model->withTrashed()->findOrFail($id)->restore();
    }
}
