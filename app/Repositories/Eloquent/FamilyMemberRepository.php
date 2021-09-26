<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\FamilyMemberRepositoryInterface;
use App\Contracts\Repository\SecurityCodeRepositoryInterface;

use App\Models\FamilyMember; 

use Throwable;
use RuntimeException;
use App\Exceptions\NotImplementedException;

use Lang; 

final class FamilyMemberRepository implements FamilyMemberRepositoryInterface
{
    protected $model;

    /** @var \App\Contracts\Repository\SecurityCodeRepositoryInterface */
    private $securityCodeRepository;
    
    /**
     * FamilyMemberRepository constructor.
     *
     * @param FamilyMember $familyMember
     */
    public function __construct(FamilyMember $familyMember, SecurityCodeRepositoryInterface $securityCodeRepository)
    {
        $this->model = $familyMember;
        $this->securityCodeRepository = $securityCodeRepository;
    }

    public function all()
    {
        throw new NotImplementedException('Method has not implemented');
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {

            $family_member = $this->model->create($data);

            $security_code = $this->securityCodeRepository->getSecurityCodeAssociate($data['patient_id']);
            $this->securityCodeRepository->update(['used_at' => now()], $security_code->id);

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();

            throw new RuntimeException(Lang::get('errors.error_processing_transaction'));
        }

        return $family_member;
    }

    public function update(array $data, $id)
    {
        throw new NotImplementedException('Method has not implemented');
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

    public function verifyRelation($user_id, $patient_id) 
    {
        $exists = $this->model
            ->where('user_id', $user_id)
            ->where('patient_id', $patient_id)
            ->first();

        return $exists ? true : false;
    }

    public function getFamilyMembers($user_id) {
        return $this->model
            ->select('patient_id')
            ->where('user_id', $user_id)
            ->get()
            ->toArray();
    }
}