<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\RoleRepositoryInterface;

use Spatie\Permission\Models\Role;

final class RoleRepository implements RoleRepositoryInterface
{
    protected $model;

    /**
     * RoleRepository constructor.
     *
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function all()
    {
        return $this->model->orderBy('name', 'ASC')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function syncPermissions(array $permissions, $id) 
    {
        return $this->model->findOrFail($id)->syncPermissions($permissions);
    }
}