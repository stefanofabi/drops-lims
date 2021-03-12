<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\ResultRepositoryInterface;

use App\Models\Result; 

use App\Exceptions\NotImplementedException;
use Exception;

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
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        throw new NotImplementedException('Not implemented');
    }

    public function delete($practice_id)
    {
        return $this->model->where('practice_id', $practice_id)->delete();
    }

    public function find($id)
    {
        throw new NotImplementedException('Not implemented');
    }

    public function findOrFail($id)
    {
        throw new NotImplementedException('Not implemented');
    }

    public function informResults(array $results, $practice_id) 
    {

        DB::beginTransaction();

        try {

            $this->model->delete($practice_id);

            foreach ($results as $result) {
                $this->create(['practice_id' => $practice_id, 'result' => $result]);
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return false;
        }

        return true;
    }
    
}