<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\SocialWorkRepositoryInterface;

use App\Models\SocialWork; 

final class SocialWorkRepository implements SocialWorkRepositoryInterface
{
    protected $model;

    /**
     * SocialWorkRepository constructor.
     *
     * @param SocialWork $socialWork
     */
    public function __construct(SocialWork $socialWork)
    {
        $this->model = $socialWork;
    }

    public function all()
    {
        return $this->model->orderBy('name', 'asc')->get();
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

    public function getSocialWorks($filter)
    {
        return $this->model
            ->select('plans.id as plan_id', "social_works.name as social_work", "plans.name as plan", "social_works.acronym")
            ->join('plans', 'social_works.id', '=', 'plans.social_work_id')
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere('social_works.name', 'ilike', "%$filter%")
                        ->orWhere('social_works.acronym', 'ilike', "$filter%")
                        ->orWhere('plans.name', 'ilike', "%$filter%");
                }
            })
            ->orderBy('social_works.name', 'ASC')
            ->get();
    }
}