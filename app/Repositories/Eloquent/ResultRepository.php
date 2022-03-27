<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\ResultRepositoryInterface;

use App\Models\Result; 

use App\Exceptions\NotImplementedException;

final class ResultRepository implements ResultRepositoryInterface
{
    protected $model;

    /**
     * ResultRepository constructor.
     *
     * @param Result $result
     */
    public function __construct(Result $result)
    {
        $this->model = $result;
    }

    public function all()
    {
        throw new NotImplementedException('Not implemented');
    }

    public function create(array $data)
    {
        $result = new Result($data);

        return $result->save() ? $result : null;
    }

    public function update(array $data, $id)
    {
        throw new NotImplementedException('Not implemented');
    }

    public function delete($id)
    {
        throw new NotImplementedException('Not implemented');
    }

    public function find($id)
    {
        throw new NotImplementedException('Not implemented');
    }

    public function findOrFail($id)
    {
        throw new NotImplementedException('Not implemented');
    }

    public function deleteAllResults($practice_id)
    {
        return $this->model->where('practice_id', $practice_id)->delete();
    }
}