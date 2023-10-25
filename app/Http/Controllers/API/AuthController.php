<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\Utilities\HttpResponse;
use App\Services\Utilities\HttpCodes;
use App\Services\Utilities\HttpMessages;
use App\Contracts\ResponseData;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;

class AuthController extends Controller
{
    /**
     * Register a new client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:clients,email',
            'username' => 'required|string|unique:clients,username',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return HttpResponse::json(new ResponseData($validator->errors(), HttpCodes::UnprocessableEntity, []));
        }

        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return HttpResponse::json(new ResponseData(HttpMessages::Created->value, HttpCodes::Created, []));
    }

    /**
     * Authenticate a client and generate a token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return HttpResponse::json(new ResponseData($validator->errors(), HttpCodes::UnprocessableEntity, []));
        }

        $client = Client::where('email', $request->email)->first();

        if (!$client || !Hash::check($request->password, $client->password)) {
            return HttpResponse::json(new ResponseData(HttpMessages::Unauthorized->value, HttpCodes::UnAuthorized, []));
        }

        $client->tokens()->delete();

        $token = $client->createToken('Client')->plainTextToken;

        $client->token = $token;

        return HttpResponse::json(new ResponseData(HttpMessages::LoggedIn->value, HttpCodes::Ok, $client->toArray()));
    }


    /**
     * Logout the authenticated client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return HttpResponse::json(new ResponseData(HttpMessages::LoggedOut->value, HttpCodes::Ok, []));
    }
}
