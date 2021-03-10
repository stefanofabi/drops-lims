<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\PaymentSocialWorkRepositoryInterface;
use App\Contracts\Repository\BillingPeriodRepositoryInterface; 

use App\Models\PaymentSocialWork; 

use App\Exceptions\QueryValidateException;

use Lang;

final class PaymentSocialWorkRepository implements PaymentSocialWorkRepositoryInterface
{
    protected $model;

    /** @var \App\Laboratory\Repositories\BillingPeriods\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    /**
     * PaymentSocialWorkRepository constructor.
     *
     * @param PaymentSocialWorkRepositoryInterface $paymentSocialWork
     */
    public function __construct(
        PaymentSocialWork $paymentSocialWork, 
        BillingPeriodRepositoryInterface $billingPeriodRepository
    ) {
        $this->model = $paymentSocialWork;
        $this->billingPeriodRepository = $billingPeriodRepository;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        $billing_period = $this->billingPeriodRepository->findOrFail($data['billing_period_id']);

        if ($billing_period->end_date > $data['payment_date']) {
            throw new QueryValidateException(Lang::get('payment_social_works.payment_before_billing_period'));
        }

        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $payment = $this->model->findOrFail($id);

        $billing_period = $payment->billing_period;

        if ($billing_period->end_date > $data['payment_date']) {
            throw new QueryValidateException(Lang::get('payment_social_works.payment_before_billing_period'));
        }
        
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
        return $this->paymentSocialWorkRepository
            ->select('payment_social_works.id', 'payment_date', 'amount', 'name as billing_period')
            ->join('billing_periods', 'payment_social_works.billing_period_id', '=', 'billing_periods.id')
            ->where('social_work_id', $social_work_id)
            ->orderBy('billing_periods.end_date', 'DESC')
            ->orderBy('payment_date', 'ASC')
            ->get();
    }
}