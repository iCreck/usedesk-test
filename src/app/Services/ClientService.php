<?php

namespace App\Services;

use App\Contracts\ClientInterface;
use App\Http\Requests\Api\Client\CreateRequest;
use App\Http\Requests\Api\Client\UpdateRequest;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class ClientService
 * @package App\Services
 */
class ClientService implements ClientInterface
{
    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Client::all();
    }

    /**
     * @param CreateRequest $request
     * @return Client
     */
    public function create(CreateRequest $request): Client
    {
        $validated = $request->validated();
        return Client::create($validated);
    }

    /**
     * @param UpdateRequest $request
     * @param Client $client
     * @return Client
     */
    public function update(UpdateRequest $request, Client $client): Client
    {
        $validated = $request->validated();
        $client->update($validated);
        return $client->fresh();
    }

    /**
     * @param Client $client
     * @return string
     * @throws \Exception
     */
    public function delete(Client $client): string
    {
        $client = $this->findById($id);
        $client->delete();
        return 'Deleted';
    }
}
