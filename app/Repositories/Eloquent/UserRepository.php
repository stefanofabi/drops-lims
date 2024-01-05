<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\UserRepositoryInterface;

use App\Models\User; 

final class UserRepository implements UserRepositoryInterface
{
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function all()
    {
        return $this->model->orderBy('full_name', 'ASC')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        // use find to trigger model events

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

    public function syncRoles($role, $id)
    {
        return $this->model->findOrFail($id)->syncRoles($role);
    }

    public function ban(array $data, $id)
    {
        return $this->model->findOrFail($id)->ban($data);
    }

    public function unban($id)
    {
        return $this->model->findOrFail($id)->unban();
    }

    public function updateLastLogin($last_login_at, $last_login_ip, $id) {
        $user = $this->model->findOrFail($id);

        $user->last_login_at = $last_login_at;
        $user->last_login_ip = $last_login_ip;
        
        return $user->save();
    }
}