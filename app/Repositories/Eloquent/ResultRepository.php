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

    public function informResults($practice_id, $results) 
    {

        DB::beginTransaction();

        try {

            $this->model->where('practice_id', $practice_id)->delete();

            // AJAX dont send empty arrays
            if (is_array($results)) {
                foreach ($results as $result) {
                    $this->create(['practice_id' => $practice_id, 'result' => $result]);
                }
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);
            return false;
        }

        return true;
    }
    
}