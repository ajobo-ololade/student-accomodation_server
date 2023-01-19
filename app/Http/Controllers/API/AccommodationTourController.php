<?php

namespace App\Http\Controllers\API;

use App\Models\AccommodationTour;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;


class AccommodationTourController extends BaseController
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
        ->tours()
        ->with(['user', 'accommodation'])
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
        $data = $request->only('tour_datetime', 'accommodation_id', 'notes');
        $validator = Validator::make($data, [
            'tour_datetime' => 'required|string',
            'accommodation_id' => 'required|numeric',
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        //Request is valid, create new tour
        $tour = AccommodationTour::create([
            'tour_datetime' => Carbon::parse($request->tour_datetime)->toDatetimeString(),
            'accommodation_id' => $request->accommodation_id,
            'notes' => $request->notes,
            'user_id' => JWTAuth::User()->id,
        ]);

        //tour created, return success response
        return $this->sendResponse([
           'success' => true,
           'data' => $tour,
       ], 'tour created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccommodationTour  $accommodationTour
     * @return \Illuminate\Http\Response
     */
    public function show($accommodationTour)
    {
        $accommodationTour = AccommodationTour::with(['user', 'accommodation'])->find($accommodationTour);
    
        if (!$accommodationTour) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, tour not found.'
            ], 400);
        }
    
        return $this->sendResponse([
            'success' => true,
            'data' => $accommodationTour,
        ], 'tour data sent successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccommodationTour  $accommodationTour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccommodationTour $accommodationTour)
    {
        //Validate data
        $data = $request->only('tour_datetime', 'notes');
        $validator = Validator::make($data, [
            'tour_datetime' => 'required|string',
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        $tour = AccommodationTour::where('id', $accommodationTour)->update([
            'tour_datetime' => Carbon::parse($request->tour_datetime)->toDatetimeString(),
            'notes' => $request->notes,
        ]);

        //tour created, return success response
        return $this->sendResponse([
           'success' => true,
           'data' => $tour,
       ], 'tour updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccommodationTour  $accommodationTour
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccommodationTour $accommodationTour)
    {
        AccommodationTour::destroy($accommodationTour);
        
        return $this->sendResponse([
            'success' => true,
            'data' => $accommodationTour,
        ], 'tour destroy successfully.');
    }
}
