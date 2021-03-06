<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ClientInterface;
use App\Http\Requests\Api\Client\CreateRequest;
use App\Http\Requests\Api\Client\UpdateRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientController extends BaseController
{
    const AVAILABLE_SEARCH_METHODS = ['name', 'phone', 'email', 'all'];

    /** @var ClientInterface */
    private $clientService;

    /**
     * ClientController constructor.
     * @param ClientInterface $clientService
     */
    public function __construct(ClientInterface $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if (
            $request->query->has('searchBy') &&
            in_array($request->query->get('searchBy'), self::AVAILABLE_SEARCH_METHODS)
        ) {
            $searchData = [
                'name' => $request->query->get('name', ''),
                'phone' => $request->query->get('phone', ''),
                'email' => $request->query->get('email', ''),
            ];
            return response()->json($this->clientService->search($request->query->get('searchBy'), $searchData));
        }
        return response()->json($this->clientService->findAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request)
    {
        return response()->json($this->clientService->create($request));
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function show(Client $client)
    {
        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  Client  $client
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Client $client)
    {
        return response()->json($this->clientService->update($request, $client));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Client $client
     * @return JsonResponse
     */
    public function destroy(Client $client)
    {
        return response()->json($client->delete(), Response::HTTP_NO_CONTENT);
    }
}
