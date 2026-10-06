<?php

namespace App\Architecture\Repositories\Classes;
use App\Architecture\Repositories\Interfaces\IAbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

abstract class AbstractRepository implements IAbstractRepository
{
    public function __construct(
        public Model $model
    )
    {
    }

    public function perPage(): int
    {
        return Cache::remember(
            'settings.pagination_limits',
            604800,
            fn () => (int) (getSetting('pagination_limits') ?? 10)
        );
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

    public function getData(
        array $conditions,
        array $columns = ['*'],
        array $relations = [],
        bool $isFirst = false,
        bool $isPagination = false
    ){
        $query = $this->prepareQuery()->select($columns)->with($relations)->where($conditions)->orderByDesc('id');

        /*
      |----------------------------------------------------------------------------------------
      | 1-$isFirst get object with conditions,relations,select columns from this model
      | 2-$isPagination get array of objects with paginate limits from settings table
      | 3-Default get array of objects with conditions,relations,select columns from this model
      |----------------------------------------------------------------------------------------
      */
        if ($isFirst) {
            return $query->first();
        }

        if($isPagination) {
            return $query->paginate($this->perPage());
        }

        return $query->orderByDesc('id')->get();

    }



}
