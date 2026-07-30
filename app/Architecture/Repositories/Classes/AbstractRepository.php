<?php

namespace App\Architecture\Repositories\Classes;
use App\Architecture\Repositories\Interfaces\IAbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements IAbstractRepository
{
    public function __construct(
        public Model $model
    )
    {
    }

    public function perPage(): int
    {
        return 30;
    }

    public function prepareQuery(): Builder
    {
        return $this->model->query();
    }

    /* -----------------------------------------------------------------
    |  Basic CRUD
    | -----------------------------------------------------------------
    */

    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    public function update(array $conditions = [], array $data = [])
    {
        $model = $this->model->where($conditions)->firstOrFail();
        $model->update($data);
        return $model;
    }

    public function updateOrCreate(array $attributes, array $values)
    {
        return $this->prepareQuery()->updateOrCreate($attributes, $values);
    }

    public function destroy($id): int
    {
        return $this->model->destroy($id);
    }

    public function softDelete($id): ?bool
    {
        $model = $this->findOrFail($id);
        return $model->delete();
    }

    public function restore($id)
    {
        $model = $this->model->onlyTrashed()->findOrFail($id);
        return $model->restore();
    }

    public function forceDelete($id)
    {
        $model = $this->model->withTrashed()->findOrFail($id);
        return $model->forceDelete();
    }

    public function massDelete(array $Ids): void
    {
        $this->prepareQuery()
            ->whereIn('id', $Ids)
            ->delete();
    }

    /* -----------------------------------------------------------------
     |  Fetching & Query Helpers
     | -----------------------------------------------------------------
     */

    public function first()
    {
        return $this->prepareQuery()->first();
    }

    public function all(array $columns = ['*'],array $relations = []): Collection
    {
        return $this->model->orderByDesc('id')->select($columns)->with($relations)->get();
    }

    public function withTrashed(): Collection
    {
        return $this->model->withTrashed()->get();
    }

    public function onlyTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    public function findOrFail($id, array $columns = ['*'], array $relations = [])
    {
        return $this->prepareQuery()
            ->select($columns)
            ->with($relations)
            ->findOrFail($id);
    }

    public function find($id, array $columns = ['*'], array $relations = [])
    {
        return $this->prepareQuery()
            ->select($columns)
            ->with($relations)
            ->find($id);
    }
    public function getWith(array $with): Collection
    {
        return $this->model->with($with)->get();
    }

    public function getWithCondition(
        $byColumn,
        $value,
        array $columns = ['*'],
        array $relations = [],
    ): array|Collection {
        return  $this->prepareQuery()->select($columns)->with($relations)->where($byColumn, $value)->get();
    }

    public function getAll(
        array $columns = ['*'],
        array $relations = [],
    ): array|Collection {
        return  $this->prepareQuery()->select($columns)->with($relations)->get();
    }

    /* -----------------------------------------------------------------
    |  Pagination
    | -----------------------------------------------------------------
    */

    public function paginate(array $condition = [], array $relations = [], $orderBy = 'ASC', $columns = ['*'])
    {
        $query = $this->prepareQuery();
        if (!empty($condition)) {
            $query->where($condition);
        }
        return $query->select($columns)
            ->with($relations)
            ->orderBy('id', $orderBy)
            ->paginate($this->perPage());
    }

}
