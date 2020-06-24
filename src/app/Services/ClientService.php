<?php

namespace App\Services;

use App\Contracts\ClientInterface;
use App\Http\Requests\Api\Client\CreateRequest;
use App\Http\Requests\Api\Client\UpdateRequest;
use App\Models\Client;
use App\Models\Email;
use App\Models\Phone;
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
        // @todo Implement phones and emails updating
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

    private function processPhones(Client $client, array $phones)
    {
        foreach ($phones as $phone) {
            $client->phones()->updateOrCreate(
                [
                    'id' => isset($phone['id']) ?: null,
                ],
                $phone
            );
        }
    }

    private function processEmails(Client $client, array $emails)
    {
        foreach ($emails as $email) {
            $client->emails()->updateOrCreate(
                [
                    'id' => isset($email['id']) ?: null,
                ],
                $email
            );
        }
    }
}
