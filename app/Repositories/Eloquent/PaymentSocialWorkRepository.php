<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\PaymentSocialWorkRepositoryInterface;

use App\Models\PaymentSocialWork; 

use App\Exceptions\QueryValidateException;

use Lang;

final class PaymentSocialWorkRepository implements PaymentSocialWorkRepositoryInterface
{
    protected $model;

    /**
     * PaymentSocialWorkRepository constructor.
     *
     * @param PaymentSocialWorkRepositoryInterface $paymentSocialWork
     */
    public function __construct(PaymentSocialWork $paymentSocialWork) 
    {
        $this->model = $paymentSocialWork;
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

    public function getPaymentsFromSocialWork($social_work_id) {
        return $this->model
            ->select('payment_social_works.id', 'payment_date', 'amount', 'name as billing_period')
            ->join('billing_periods', 'payment_social_works.billing_period_id', '=', 'billing_periods.id')
            ->where('social_work_id', $social_work_id)
            ->orderBy('billing_periods.end_date', 'DESC')
            ->orderBy('payment_date', 'ASC')
            ->get();
    }
}