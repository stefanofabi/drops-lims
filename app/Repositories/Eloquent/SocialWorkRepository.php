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

    public function getSocialWorks($filter_name)
    {
        $social_works = $this->model
            ->select('plans.id as plan_id', DB::raw("CONCAT(social_works.name, ' - ', plans.name) as label"))
            ->join('plans', 'social_works.id', '=', 'plans.social_work_id')
            ->where(function ($query) use ($filter_name) {
                if (! empty($filter_name)) {
                    $query->orWhere("social_works.name", "ilike", "%$filter_name%")
                        ->orWhere("social_works.acronym", "ilike", "$filter_name%")
                        ->orWhere("plans.name", "ilike", "$filter_name%");
                }
            }) 
            ->get();

        if ($social_works->isEmpty()) 
        {
            return response()->json(['label' => 'No records found']);
        }
        
        return $social_works;
    }
}