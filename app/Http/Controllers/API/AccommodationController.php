<?php

namespace App\Http\Controllers\API;

use App\Models\Accommodation;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class AccommodationController extends BaseController
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
            ->accommodations()
            ->with('ratings')
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
        $data = $request->only('hostel_address', 'amount', 'image', 'facilities', 'info');
        $validator = Validator::make($data, [
            'hostel_address' => 'required|string',
            'amount' => 'required|numeric',
            'image' => 'required',
            'facilities' => 'required|string',
            'info' => 'required|string',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        $png_url = "perfil-".time().".jpg";
        $path = public_path() . "/uploads/" . $png_url;
        $img = $request['image'];
        $img = substr($img, strpos($img, ",")+1);
        $data = base64_decode($img);
        $success = file_put_contents($path, $data);
        // $image_path = $request->file('image')->store('image', 'public');


        //Request is valid, create new accommodation
        $accommodation = $this->user->accommodations()->create([
            'hostel_address' => $request->hostel_address,
            'amount' => $request->amount,
            'image' => $path,
            'facilities' => $request->facilities,
            'info' => $request->info,
        ]);

        //Accommodation created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Accommodation created successfully',
            'data' => $accommodation
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accommodation  $accommodation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $accommodation = $this->user->accommodations()->with('ratings')->find($id);

        if (!$accommodation) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, accommodation not found.'
            ], 400);
        }

        return $accommodation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accommodation  $accommodation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accommodation $accommodation)
    {

        //Validate data
        $data = $request->only('hostel_address', 'amount', 'image', 'facilities', 'info');
        $validator = Validator::make($data, [
            'hostel_address' => 'required|string',
            'amount' => 'required|numeric',
            'image' => 'required',
            'facilities' => 'required|string',
            'info' => 'required|string',
        ]);

        $png_url = "perfil-".time().".jpg";
        $path = public_path() . "/uploads/" . $png_url;
        $img = $request['image'];
        $img = substr($img, strpos($img, ",")+1);
        $data = base64_decode($img);
        $success = file_put_contents($path, $data);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        // $image_path = $request->file('image')->store('image', 'public');

        //Request is valid, update accommodation
        $accommodation = $accommodation->update([
            'hostel_address' => $request->hostel_address,
            'amount' => $request->amount,
            'image' => $path,
            'facilities' => $request->facilities,
            'info' => $request->info,
        ]);

        //Accommodation updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Accommodation updated successfully',
            'data' => $accommodation
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accommodation  $accommodation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accommodation $accommodation)
    {
        $accommodation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Accommodation deleted successfully'
        ], Response::HTTP_OK);
    }
}
