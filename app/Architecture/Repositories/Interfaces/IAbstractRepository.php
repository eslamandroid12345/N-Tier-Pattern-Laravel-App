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

    public function softDelete($id);
    public function restore($id);
    public function forceDelete($id);
    public function massDelete(array $Ids);
    /* -----------------------------------------------------------------
    |  Fetching & Query Helpers
    | -----------------------------------------------------------------
    */
    public function first();
    public function all(array $columns = ['*'],array $relations = []);
    public function withTrashed();
    public function onlyTrashed();

    public function findOrFail($id, array $columns = ['*'], array $relations = []);
    public function getWith(array $with);
    public function getWithCondition(
        array $data,
        array $columns = ['*'],
        array $relations = [],
        bool $isFirst = false
    );
    public function getAll(array $columns = ['*'], array $relations = [],);
    /* -----------------------------------------------------------------
   |  Pagination
   | -----------------------------------------------------------------
   */
    public function paginate(array $condition = [], array $relations = [], $orderBy = 'ASC', $columns = ['*']);
}
