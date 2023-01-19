<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Http\Controllers\API\BaseController as BaseController;
use Symfony\Component\HttpFoundation\Response;

class PublicController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accommodation = Accommodation::paginate(100);

             //Accommodation get, return success response
        return response()->json([
            'success' => true,
            'message' => 'Accommodation created successfully',
            'data' => $accommodation
        ], Response::HTTP_OK);
    }


}
