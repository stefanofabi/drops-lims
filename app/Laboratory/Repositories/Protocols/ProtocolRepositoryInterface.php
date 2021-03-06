<?php

namespace App\Laboratory\Repositories\Protocols;

interface ProtocolRepositoryInterface
{
    public function all();

    public function create(array $protocolData, array $childProtocolData);

    public function update(array $protocolData, array $childProtocolData, $id);

    public function delete($id);

    public function find($id);

    public function findOrFail($id);
}