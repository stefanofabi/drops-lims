<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\PaymentSocialWorkRepositoryInterface;

use App\Models\PaymentSocialWork; 

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
        $payment = new PaymentSocialWork($data);

        return $payment->save() ? $payment : null;
    }

    public function update(array $data, $id)
    {       
        $payment = $this->model->findOrFail($id);

        return $payment->update($data);
    }

    public function delete($id)
    {
        $payment = $this->model->findOrFail($id);

        return $payment->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getDebt()
    {
        return $this->model
            ->select('practices.id', 'practices.amount')
            ->join('social_works', 'social_works.id', '=', 'payment_social_works.social_work_id')
            ->join('plans', 'plans.social_work_id', '=', 'social_works.id')
            ->join('protocols', 'protocols.plan_id', '=', 'plans.id')
            ->join('practices', 'practices.protocol_id', '=', 'protocols.id')
            ->where('protocols.type', 'our')
            ->groupBy('practices.id', 'practices.amount')
            ->get();
    }
}