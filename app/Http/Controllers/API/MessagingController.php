<?php

namespace App\Http\Controllers\API;

use App\Models\Messaging;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use JWTAuth;
use Illuminate\Support\Facades\Validator;

class MessagingController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user
            ->messages()
            ->with(['agent', 'user'])
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only('agent_id', 'message');
        $validator = Validator::make($data, [
            'agent_id' => 'required|numeric',
            'message' => 'required|string',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        //Request is valid, create new tour
        $message = Messaging::create([
            'agent_id' => $request->agent_id,
            'message' => $request->message,
            'user_id' => JWTAuth::User()->id,
        ]);

        //tour created, return success response
        return $this->sendResponse([
            'success' => true,
            'data' => $message,
        ], 'message created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Messaging  $messaging
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messaging $messaging)
    {
        Messaging::destroy($messaging);

        return $this->sendResponse([
            'success' => true,
            'data' => $messaging,
        ], 'message destroy successfully.');
    }
}
