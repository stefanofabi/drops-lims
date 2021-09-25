<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\FamilyMemberRepositoryInterface;

use App\Models\FamilyMember; 

final class FamilyMemberRepository implements FamilyMemberRepositoryInterface
{
    protected $model;

    /**
     * FamilyMemberRepository constructor.
     *
     * @param FamilyMember $familyMember
     */
    public function __construct(FamilyMember $familyMember)
    {
        $this->model = $familyMember;
    }

    public function all()
    {
        
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        
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
}