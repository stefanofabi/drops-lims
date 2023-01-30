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
            ->select('social_works.id as social_work_id', 'social_works.name as social_work', 'social_works.acronym', 'plans.id as plan_id', 'plans.name as plan')
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

    public function getSocialWorkComposition ()
    {
        return $this->model
            ->select('social_works.id', 'social_works.name')
            ->selectRaw('COUNT(*) as total_orders')
            ->join('plans', 'social_works.id', '=', 'plans.social_work_id')
            ->join('internal_protocols', 'plans.id', '=', 'internal_protocols.plan_id')
            ->groupBy('social_works.id')
            ->get();
    }
}