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
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
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
}