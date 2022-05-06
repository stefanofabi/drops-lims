<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\FamilyMemberRepositoryInterface;

use App\Models\FamilyMember;

use App\Exceptions\NotImplementedException;

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
        throw new NotImplementedException('Method has not implemented');
    }

    public function create(array $data)
    {
        $family_member = new FamilyMember($data);

        return $family_member->save() ? $family_member : null;
    }

    public function update(array $data, $id)
    {
        throw new NotImplementedException('Method has not implemented');
    }

    public function delete($id)
    {
        $family_member = $this->model->findOrFail($id);

        return $family_member->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findFamilyMemberRelationOrFail($user_id, $patient_id) 
    {
        return $this->model
            ->where('user_id', $user_id)
            ->where('internal_patient_id', $patient_id)
            ->firstOrFail();
    }

    public function getFamilyMembers($user_id) 
    {
        return $this->model
            ->select('internal_patient_id')
            ->where('user_id', $user_id)
            ->get();
    }
}