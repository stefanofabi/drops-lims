<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;

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

    public function getSumOfAllPayments()
    {
        return $this->model
            ->select(DB::raw('SUM(amount) as total_amount'))
            ->get()
            ->first();
    }
}