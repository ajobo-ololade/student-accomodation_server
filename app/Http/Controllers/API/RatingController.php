<?php

namespace App\Http\Controllers\API;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use JWTAuth;
use Illuminate\Support\Facades\Validator;

class RatingController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //Validate data
         $data = $request->only('star_number', 'description', 'accommodation_id');
         $validator = Validator::make($data, [
             'star_number' => 'required|numeric',
             'description' => 'required|string',
             'accommodation_id' => 'required|numeric',
         ]);
         
         //Send failed response if request is not valid
         if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

         //Request is valid, create new rating
         $rating = Rating::create([
             'star_number' => $request->star_number,
             'description' => $request->description,
             'accommodation_id' => $request->accommodation_id,
             'rated_by' => JWTAuth::User()->id,
         ]);
 
         //Rating created, return success response
         return $this->sendResponse([
            'success' => true,
            'data' => $rating,
        ], 'rating created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show($rating)
    {
        $rating = Rating::find($rating);
    
        if (!$rating) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, rating not found.'
            ], 400);
        }
    
        return $this->sendResponse([
            'success' => true,
            'data' => $rating,
        ], 'rating data sent successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //Validate data
        $data = $request->only('star_number', 'description');
        $validator = Validator::make($data, [
            'star_number' => 'required|numeric',
            'description' => 'required|string'
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        $rating = Rating::where('id', $rating)->update([
            'star_number' => $request->star_number,
            'description' => $request->description,
        ]);

        //Rating created, return success response
        return $this->sendResponse([
           'success' => true,
           'data' => $rating,
       ], 'rating updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        Rating::destroy($rating);
        
        return $this->sendResponse([
            'success' => true,
            'data' => $rating,
        ], 'rating destroy successfully.');
    }
}
