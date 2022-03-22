<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\SecurityCodeRepositoryInterface;

use App\Models\SecurityCode; 

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Exceptions\PrintException;
use App\Exceptions\NotImplementedException;
use Throwable;

use Lang;

final class SecurityCodeRepository implements SecurityCodeRepositoryInterface
{

    private const SECURITY_CODE_LENGTH = 10;
    private const DAYS_TO_EXPIRATE_SECURITY_CODE = 10;

    protected $model;

    /**
     * SecurityCodeRepository constructor.
     *
     * @param SecurityCode $security_code
     */
    public function __construct(SecurityCode $security_code)
    {
        $this->model = $security_code;
    }

    public function all()
    {
        throw new NotImplementedException('Method has not implemented');
    }

    public function create(array $data)
    {         
        $new_security_code = Str::random(self::SECURITY_CODE_LENGTH);

        $date_today = date("Y-m-d");
        $new_expiration_date = date("Y-m-d", strtotime($date_today."+ ".self::DAYS_TO_EXPIRATE_SECURITY_CODE." days"));

        DB::beginTransaction();
        
        try {
            $security_code = $this->model->where(['patient_id' => $data['patient_id']])->delete();

            $security_code = new SecurityCode([
                'patient_id' => $data['patient_id'],
                'security_code' => Hash::make($new_security_code),
                'expiration_date' => $new_expiration_date,
                'used_at' => null,
            ]);

            $security_code->save();

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            
            throw new PrintException(Lang::get('errors.generate_pdf'));
        }
        
        return [
            'security_code' => $new_security_code,
            'expiration_date' => $new_expiration_date
        ];
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
        throw new NotImplementedException('Method has not implemented');
    }

    public function findOrFail($patient_id)
    {
        throw new NotImplementedException('Method has not implemented');
    }

    public function getSecurityCodeAssociate($patient_id) 
    {
        return $this->model->where('patient_id', $patient_id)->first();
    }
}