<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\ReportRepositoryInterface;

use App\Models\Report; 

final class ReportRepository implements ReportRepositoryInterface
{
    protected $model;

    /**
     * ReportRepository constructor.
     *
     * @param Report $billingPeriod
     */
    public function __construct(Report $report)
    {
        $this->model = $report;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        $report = new Report($data);

        return $report->save() ? $report : null;
    }

    public function update(array $data, $id)
    {
        $report = $this->model->findOrFail($id);

        return $report->update($data);
    }

    public function delete($id)
    {
        $report = $this->model->findOrFail($id);

        return $report->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
    
    public function getReportsFromNomenclator($nomenclator_id, $filter) {
        $reports = $this->model
            ->select('reports.id', DB::raw("CONCAT(determinations.name, ' - ', reports.name) as label"))
            ->join('determinations', 'determinations.id', '=', 'reports.determination_id')
            ->where('determinations.nomenclator_id', $nomenclator_id)
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("determinations.name", "like", "%$filter%")
                        ->orWhere("determinations.code", "like", "$filter%")
                        ->orWhere("reports.name", "like", "%$filter%");
                }
            })
            ->take(15)
            ->orderBy('determinations.name', 'ASC')
            ->orderBy('reports.name', 'ASC')
            ->get();

            
        if ($reports->isEmpty()) 
        {
            return response()->json(['label' => 'No records found']);
        }

        return $reports;
    }
}