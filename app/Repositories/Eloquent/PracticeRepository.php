<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\PracticeRepositoryInterface;

use App\Models\Practice; 

use App\Exceptions\NotImplementedException;

final class PracticeRepository implements PracticeRepositoryInterface
{
    protected $model;

    /**
     * PracticeRepository constructor.
     *
     * @param Practice $practice
     */
    public function __construct(Practice $practice)
    {
        $this->model = $practice;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        $practice = new Practice($data);

        return $practice->save();
    }

    public function update(array $data, $id)
    {
        $practice = $this->model->findOrFail($id);
        
        return $practice->update($data);
    }

    public function delete($id)
    {
        $practice = $this->model->findOrFail($id);

        return $practice->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getPracticePrice($report, $protocol) 
    {
        $determination = $report->determination;
        $biochemical_unit = $determination->biochemical_unit;

        switch ($protocol->type) {
            case 'our':
            {
                $plan = $protocol->plan;
                $nbu_price = $plan->nbu_price;
                $amount = $nbu_price * $biochemical_unit;

                break;
            }

            case 'derived':
            {
                throw new NotImplementedException('Not implemented');
            }
        }

        return $amount;
    }

    public function getPracticesNotSigned() 
    {
        return $this->model
            ->leftJoin('sign_practices', 'practices.id', '=', 'sign_practices.practice_id')
            ->where('sign_practices.practice_id', null)
            ->get();
    }
}