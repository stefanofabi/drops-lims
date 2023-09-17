<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\SystemParameterRepositoryInterface;

use App\Models\SystemParameter;

use App\Exceptions\NotImplementedException;

final class SystemParameterRepository implements SystemParameterRepositoryInterface
{
    protected $model;

    /**
     * SystemParameter constructor.
     *
     * @param Role $system_parameter
     */
    public function __construct(SystemParameter $system_parameter)
    {
        $this->model = $system_parameter;
    }

    public function all()
    {
        throw NotImplementedException("SystemParameter::all() not implemented");
    }

    public function create(array $data)
    {
        throw NotImplementedException("SystemParameter::create(data) not implemented");
    }

    public function update(array $data, $id)
    {
        throw NotImplementedException("SystemParameter::update(data, id) not implemented");
    }

    public function delete($id)
    {
        throw NotImplementedException("SystemParameter::delete(id) not implemented");
    }

    public function find($id)
    {
        throw NotImplementedException("SystemParameter::find(id) not implemented");
    }

    public function findOrFail($id)
    {
        throw NotImplementedException("SystemParameter::findOrFail(id) not implemented");
    }

    public function findByCategory($category) 
    {
        return $this->model->where('category', $category)->orderBy('id', 'ASC')->get();
    }

    public function allCategories()
    {
        return $this->model->select('category')->groupBy('category')->get();
    }

    public function updateParameterByKey($key, $array_values)
    {
        return $this->model->where('key', $key)->firstOrFail()->update($array_values);
    }

    public function findByKeyOrFail($key)
    {
        return $this->model->where('key', $key)->firstOrFail();
    }
}