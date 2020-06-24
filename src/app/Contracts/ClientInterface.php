<?php

namespace App\Contracts;

use App\Http\Requests\Api\Client\CreateRequest;
use App\Http\Requests\Api\Client\UpdateRequest;
use App\Models\Client;
use Illuminate\Support\Collection;

interface ClientInterface
{
    public function findAll(): Collection;
    public function create(CreateRequest $request): Client;
    public function update(UpdateRequest $request, Client $client): Client;
    public function delete(Client $client): string;
}
