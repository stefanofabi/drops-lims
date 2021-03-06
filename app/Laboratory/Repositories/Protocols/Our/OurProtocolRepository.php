<?php

namespace App\Laboratory\Repositories\Protocols\Our;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use App\Laboratory\Repositories\Protocols\Our\OurProtocolRepositoryInterface;
use App\Models\Protocol; 
use App\Models\OurProtocol; 

final class OurProtocolRepository implements OurProtocolRepositoryInterface
{
    protected $ourProtocolModel;
    protected $protocolModel;

    /**
     * OurProtocolRepository constructor.
     *
     * @param Protocol $protocol
     * @param OurProtocol $ourProtocol
     */
    public function __construct(Protocol $protocol, OurProtocol $ourProtocol)
    {
        $this->protocolModel = $protocol;
        $this->ourProtocolModel = $ourProtocol;
    }

    public function all()
    {
        //return $this->model->all();
    }

    public function create(array $protocolData, array $ourProtocolData)
    {
        DB::beginTransaction();

        try {
            $protocol = $this->protocolModel->create($protocolData);
            $our_protocol = $this->ourProtocolModel->create(array_merge(['protocol_id' => $protocol->id], $ourProtocolData));
            
            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();

            return null;
        }

        return $our_protocol;
    }

    public function update(array $protocolData, array $ourProtocolData, $id)
    {
        DB::beginTransaction();

        try {
            $this->protocolModel->where('id', $id)->update($protocolData);

            $this->ourProtocolModel->where('protocol_id', $id)->update($ourProtocolData);

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();

            return 0;
        }

        return 1;
    }

    public function delete($id)
    {
        //return $this->ourProtocolModel->destroy($id);
    }

    public function find($id)
    {
        return $this->ourProtocolModel->find($id);
    }

    public function findOrFail($id)
    {
        return $this->ourProtocolModel->findOrFail($id);
    }

    public function getPractices($protocol_id) {
        $protocol = $this->protocolModel->findOrFail($protocol_id);

        return $protocol->practices;
    }
}