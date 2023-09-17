<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\BillingPeriodRepositoryInterface;

use App\Models\BillingPeriod; 

final class BillingPeriodRepository implements BillingPeriodRepositoryInterface
{
    protected $model;

    /**
     * BillingPeriodRepository constructor.
     *
     * @param BillingPeriod $billingPeriod
     */
    public function __construct(BillingPeriod $billingPeriod)
    {
        $this->model = $billingPeriod;
    }

    public function all()
    {
        return $this->model->orderBy('start_date', 'DESC')->get();
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

    /**
     * Returns a list of the latest billing periods.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBillingPeriods() {
        $current_date = date('Y-m-d');
        
        $start_date = date("Y-m-d", strtotime($current_date."- 6 month"));
        $end_date = date("Y-m-d", strtotime($current_date."+ 6 month"));

        return $this->model
            ->where('start_date', '>=', $start_date)
            ->where('end_date', '<=', $end_date)
            ->orderBy('start_date', 'ASC')
            ->orderBy('end_date', 'ASC')
            ->get();
    }

    /**
     * Returns true if there is no overlap, otherwise returns false.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkOverlapDates($start_date, $end_date, $id = null)
    {
        /** 
         * Two time periods P1 and P2 overlaps if, and only if, at least one of these conditions hold:
         * P1 starts between the start and end of P2 (P2.from <= P1.from <= P2.to)
         * P2 starts between the start and end of P1 (P1.from <= P2.from <= P1.to)
         */

        return $this->model
            ->where(function($query) use ($id) {
                if (! empty($id)) {
                    $query->where('id', '<>', $id);
                }
            })
            ->where(function($query) use ($start_date, $end_date) {
                $query->orWhere(function($query) use ($start_date, $end_date) {
                    
                    $query->where('start_date', '<=', $start_date)
                    ->where('end_date', '>=', $start_date);
                });

                $query->orWhere(function($query) use ($start_date, $end_date) {
                    $query->orWhere('start_date', '>=', $start_date)
                    ->where('start_date', '<=', $end_date);
                });
            })
            ->get()
            ->isEmpty();
    }

    /**
     * Returns current billing period.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCurrentBillingPeriod() 
    {
        $current_date = date('Y-m-d');

        return $this->model
            ->where('start_date', '<=', $current_date)
            ->where('end_date', '>=', $current_date)
            ->first();

    }

    /**
     * Returns a list billing periods filtered.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadBillingPeriods($filter) {
        return $this->model
            ->select('id', 'name', 'start_date', 'end_date')
            ->where('name', 'ilike', "%$filter%")
            ->orderBy('start_date', 'DESC')
            ->get();
    }

    public function getAmountBilledByPeriod($social_work_id, $start_date, $end_date) 
    {   
        $collected_periods = DB::table('internal_protocols')
            ->select('internal_protocols.billing_period_id')
            ->selectRaw('SUM(internal_protocols.total_price) as total_collection')
            ->join('plans', 'internal_protocols.plan_id', '=', 'plans.id')
            ->where('plans.social_work_id', $social_work_id)
            ->groupBy('internal_protocols.billing_period_id');

        $total_paid = DB::table('payment_social_works')
            ->select('payment_social_works.billing_period_id')
            ->selectRaw('SUM(payment_social_works.amount) as total_paid')
            ->where('payment_social_works.social_work_id', $social_work_id)
            ->groupBy('payment_social_works.billing_period_id');

        return $this->model
            ->select('billing_periods.name', 'billing_periods.start_date', 'billing_periods.end_date')
            ->selectRaw('COALESCE(collected_periods.total_collection, 0) as total_collection')
            ->selectRaw('COALESCE(total_paid.total_paid, 0) as total_paid')
            ->leftJoinSub($collected_periods, 'collected_periods', function ($join) {
                $join->on('billing_periods.id', '=', 'collected_periods.billing_period_id');
            })
            ->leftJoinSub($total_paid, 'total_paid', function ($join) {
                $join->on('billing_periods.id', '=', 'total_paid.billing_period_id');
            })
            ->where('billing_periods.start_date', '>=', $start_date)
            ->where('billing_periods.end_date', '<=', $end_date)
            ->groupBy('billing_periods.id', 'billing_periods.name', 'collected_periods.total_collection', 'total_paid.total_paid')
            ->orderBy('billing_periods.start_date', 'ASC')
            ->get();
    }

    /*
    * Returns a list with the collection of a social work in the specified billing periods
    */
    public function getCollectionSocialWork($social_work_id, $start_date, $end_date) 
    {
        $collected_periods = DB::table('internal_protocols')
            ->select('internal_protocols.billing_period_id')
            ->selectRaw('SUM(internal_protocols.total_price) as total_collection')
            ->join('plans', 'internal_protocols.plan_id', '=', 'plans.id')
            ->join('social_works', 'plans.social_work_id', '=', 'social_works.id')
            ->where('social_works.id', $social_work_id)
            ->groupBy('internal_protocols.billing_period_id');

        $total_paid = DB::table('payment_social_works')
        ->select('payment_social_works.billing_period_id')
        ->selectRaw('SUM(payment_social_works.amount) as total_paid')
        ->where('payment_social_works.social_work_id', $social_work_id)
        ->groupBy('payment_social_works.billing_period_id');

        return $this->model
            ->select('billing_periods.id', 'billing_periods.name')
            ->selectRaw('COALESCE(collected_periods.total_collection, 0) as total_collection')
            ->selectRaw('COALESCE(total_paid.total_paid, 0) as total_paid')
            ->leftJoinSub($collected_periods, 'collected_periods', function ($join) {
                $join->on('billing_periods.id', '=', 'collected_periods.billing_period_id');
            })
            ->leftJoinSub($total_paid, 'total_paid', function ($join) {
                $join->on('billing_periods.id', '=', 'total_paid.billing_period_id');
            })
            ->where('billing_periods.start_date', '>=', $start_date)
            ->where('billing_periods.end_date', '<=', $end_date)
            ->groupBy('billing_periods.id', 'billing_periods.name', 'collected_periods.total_collection', 'total_paid.total_paid')
            ->orderBy('billing_periods.start_date', 'ASC')
            ->get();
    }

    /*
    * Returns a list with the flow of patients in the specified billing periods
    */
    public function getPatientFlow($start_date, $end_date) 
    {
        $total_patients = DB::table('internal_protocols')
            ->select('internal_protocols.billing_period_id')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('internal_protocols.billing_period_id');

        return $this->model
            ->select('billing_periods.id', 'billing_periods.name')
            ->selectRaw('COALESCE(total_patients.total, 0) as total')
            ->leftJoinSub($total_patients, 'total_patients', function ($join) {
                $join->on('billing_periods.id', '=', 'total_patients.billing_period_id');
            })
            ->where('billing_periods.start_date', '>=', $start_date)
            ->where('billing_periods.end_date', '<=', $end_date)
            ->groupBy('billing_periods.id', 'billing_periods.name', 'total_patients.total')
            ->orderBy('billing_periods.start_date', 'ASC')
            ->get();
    }

    /*
    * Returns a list of the lab's revenue for the specified billing periods
    */
    public function getTrackIncome($start_date, $end_date) 
    {
        $total_income = DB::table('internal_protocols')
            ->select('internal_protocols.billing_period_id')
            ->selectRaw('SUM(internal_protocols.total_price) as total_income')
            ->groupBy('internal_protocols.billing_period_id');

        $total_paid = DB::table('payment_social_works')
            ->select('payment_social_works.billing_period_id')
            ->selectRaw('SUM(payment_social_works.amount) as total_paid')
            ->groupBy('payment_social_works.billing_period_id');

        return $this->model
            ->select('billing_periods.id', 'billing_periods.name')
            ->selectRaw('COALESCE(total_income.total_income, 0) as total_income')
            ->selectRaw('COALESCE(total_paid.total_paid, 0) as total_paid')
            ->leftJoinSub($total_income, 'total_income', function ($join) {
                $join->on('billing_periods.id', '=', 'total_income.billing_period_id');
            })
            ->leftJoinSub($total_paid, 'total_paid', function ($join) {
                $join->on('billing_periods.id', '=', 'total_paid.billing_period_id');
            })
            ->where('billing_periods.start_date', '>=', $start_date)
            ->where('billing_periods.end_date', '<=', $end_date)
            ->groupBy('billing_periods.id', 'billing_periods.name', 'total_income.total_income', 'total_paid.total_paid')
            ->orderBy('billing_periods.start_date', 'ASC')
            ->get();
    }
}