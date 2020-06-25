<?php

namespace App\Services;

use App\Contracts\ClientInterface;
use App\Http\Requests\Api\Client\CreateRequest;
use App\Http\Requests\Api\Client\UpdateRequest;
use App\Models\Client;
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
        $client = Client::create($validated);
        $this->processPhones($client, $validated['phones']);
        $this->processEmails($client, $validated['emails']);
        return $client->fresh(['phones', 'emails']);
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
        $this->processPhones($client, $validated['phones']);
        $this->processEmails($client, $validated['emails']);
        return $client->refresh();
    }

    protected function processPhones(Client $client, array $phones)
    {
        $unusedIds = $this->getUnusedIds($client->phones, $phones);
        $unusedIds->each(function ($element) use ($client) {
            $client
                ->phones()
                ->where('id', $element->id)
                ->delete();
        });
        foreach ($phones as $phone) {
            $client->phones()->updateOrCreate(
                [
                    'id' => array_key_exists('id', $phone) ? $phone['id'] : null,
                ],
                $phone
            );
        }
    }

    protected function processEmails(Client $client, array $emails)
    {
        $unusedIds = $this->getUnusedIds($client->emails, $emails);
        $unusedIds->each(function ($element) use ($client) {
            $client
                ->emails()
                ->where('id', $element->id)
                ->delete();
        });
        foreach ($emails as $email) {
            $client->emails()->updateOrCreate(
                [
                    'id' => isset($email['id']) ?: null,
                ],
                $email
            );
        }
    }

    protected function getUnusedIds(Collection $itemsList, array $newItemsList)
    {
        $newIds = collect($newItemsList)->map(function ($search) {
            return array_key_exists('id', $search) ? $search['id'] : null;
        });
        return $itemsList->filter(function ($item) use ($newIds) {
            return !$newIds->contains($item->id);
        });
    }
}
