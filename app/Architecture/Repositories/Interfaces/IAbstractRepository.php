<?php

namespace App\Architecture\Repositories\Interfaces;

interface IAbstractRepository
{
    public function prepareQuery();

    /* -----------------------------------------------------------------
    |  Basic CRUD
    | -----------------------------------------------------------------
    */
    public function create(array $data);
    public function insert(array $data);
    public function update(array $conditions = [], array $data = []);
    public function updateOrCreate(array $attributes, array $values);

    public function destroy($id);

    public function restore($id);
    public function forceDelete($id);
    public function massDelete(array $Ids);
    /* -----------------------------------------------------------------
    |  Fetching & Query Helpers
    | -----------------------------------------------------------------
    */
    public function all(array $columns = ['*'],array $relations = []);
    public function withTrashed();
    public function onlyTrashed();

    public function findOrFail($id, array $columns = ['*'], array $relations = []);
    public function getData(
        array $conditions,
        array $columns = ['*'],
        array $relations = [],
        bool $isFirst = false,
        bool $isPagination = false
    );
}
