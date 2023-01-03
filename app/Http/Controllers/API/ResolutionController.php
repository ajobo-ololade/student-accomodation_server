<?php

namespace App\Http\Controllers\API;

use App\Models\Resolution;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use JWTAuth;
use Illuminate\Support\Facades\Validator;

class ResolutionController extends BaseController
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
            ->resolutions()
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
        $data = $request->only('agent_id', 'details');
        $validator = Validator::make($data, [
            'agent_id' => 'required|numeric',
            'details' => 'required|string',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        //Request is valid, create new tour
        $resolution = Resolution::create([
            'agent_id' => $request->agent_id,
            'details' => $request->details,
            'user_id' => JWTAuth::User()->id,
        ]);

        //tour created, return success response
        return $this->sendResponse([
            'success' => true,
            'data' => $resolution,
        ], 'resolution created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function show($resolution)
    {
        $resolution = Resolution::with(['user', 'agent'])->find($resolution);

        if (!$resolution) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, resolution not found.'
            ], 400);
        }

        return $this->sendResponse([
            'success' => true,
            'data' => $resolution,
        ], 'resolution data sent successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function edit(Resolution $resolution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resolution $resolution)
    {
        //Validate data
        $data = $request->only('agent_id', 'details');
        $validator = Validator::make($data, [
            'agent_id' => 'required|numeric',
            'details' => 'required|string',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        $tour = Resolution::where('id', $resolution)->update([
            'details' => $request->details,
        ]);

        //tour created, return success response
        return $this->sendResponse([
            'success' => true,
            'data' => $tour,
        ], 'resolution updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resolution $resolution)
    {
        Resolution::destroy($resolution);

        return $this->sendResponse([
            'success' => true,
            'data' => $resolution,
        ], 'resolution destroy successfully.');
    }
}
