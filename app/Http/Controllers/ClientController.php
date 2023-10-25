<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\Utilities\HttpResponse;
use App\Services\Utilities\HttpCodes;
use App\Services\Utilities\HttpMessages;
use App\Contracts\ResponseData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * Display the Clients page.
     */
    public function get(Request $request): Response
    {
        $clients = Client::paginate(8);
        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }

    /**
     * Delete the client's account.
     */
    public function destroy($id): JsonResponse
    {
        $client = Client::find($id);
        if (!$client) {
            return HttpResponse::json(new ResponseData(HttpMessages::NotFound->value, HttpCodes::NotFound, []));
        }

        try {
            $deleted = $client->delete();
            if (!$deleted) {
                return HttpResponse::json(new ResponseData(HttpMessages::ServiceUnavailable->value, HttpCodes::ServiceUnavailable, []));
            }
            return HttpResponse::json(new ResponseData(HttpMessages::Deleted->value, HttpCodes::Ok, []));
        } catch (\Exception $e) {
            return HttpResponse::json(new ResponseData(HttpMessages::ServiceUnavailable->value . ':' . $e->getMessage(), HttpCodes::ServiceUnavailable, []));
        }
    }
}
